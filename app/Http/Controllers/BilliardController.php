<?php

namespace App\Http\Controllers;

use App\Models\BilliardTable;
use App\Models\BilliardRental;
use App\Services\ReceiptService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BilliardController extends Controller
{
    public function __construct(
        private ReceiptService $receiptService,
        private WhatsAppService $whatsappService
    ) {}

    /**
     * Show the booking form
     */
    public function index()
    {
        $tables = BilliardTable::orderBy('table_number')->get();
        return view('billiard.index', compact('tables'));
    }

    /**
     * Show the booking form with table dropdown
     */
    public function book(BilliardTable $table = null)
    {
        $user = Auth::user();
        $tables = BilliardTable::orderBy('table_number')->get();

        // If a specific table is passed, use it as default selection
        $selectedTable = $table;

        return view('billiard.book', compact('tables', 'selectedTable', 'user'));
    }

    /**
     * Process the booking (Pay button)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'billiard_table_id' => 'required|exists:billiard_tables,id',
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'nullable|string|max:20',
            'duration_hours' => 'required|integer|min:1|max:24',
            'rental_start' => 'required|date|after_or_equal:now',
        ]);

        DB::beginTransaction();

        try {
            $table = BilliardTable::findOrFail($validated['billiard_table_id']);
            $user = Auth::user();
            $isMember = (bool) $user;

            $rentalStart = Carbon::parse($validated['rental_start']);
            $durationHours = (int) $validated['duration_hours'];
            $rentalEnd = $rentalStart->copy()->addHours($durationHours);

            // Check availability
            if (!$table->isAvailableAt($rentalStart, $rentalEnd)) {
                return back()->withErrors(['rental_start' => 'Table is not available at the selected time.'])
                    ->withInput();
            }

            // Calculate pricing
            $pricing = BilliardRental::calculatePrice($validated['duration_hours'], $isMember);

            // Create rental record
            $rental = BilliardRental::create([
                'billiard_table_id' => $table->id,
                'user_id' => $user?->id,
                'customer_name' => $validated['customer_name'],
                'customer_whatsapp' => $validated['customer_whatsapp'],
                'duration_hours' => $validated['duration_hours'],
                'price_per_hour' => $pricing['price_per_hour'],
                'subtotal' => $pricing['subtotal'],
                'discount_amount' => $pricing['discount_amount'],
                'total_amount' => $pricing['total_amount'],
                'status' => BilliardRental::STATUS_PENDING,
                'rental_start' => $rentalStart,
                'rental_end' => $rentalEnd,
            ]);

            // Generate receipt (PDF and image)
            $this->receiptService->generateReceipt($rental);

            // Send to WhatsApp if phone number provided
            if ($validated['customer_whatsapp']) {
                $this->whatsappService->sendReceipt($rental, $this->receiptService);
            }

            DB::commit();

            return redirect()->route('billiard.success', $rental)
                ->with('success', 'Booking created successfully! Receipt has been sent to your WhatsApp.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show booking success page
     */
    public function success(BilliardRental $rental)
    {
        $whatsappLink = null;
        if ($rental->customer_whatsapp) {
            $whatsappLink = $this->whatsappService->getWhatsAppLinkForRental($rental);
        }

        return view('billiard.success', compact('rental', 'whatsappLink'));
    }

    /**
     * Show rental history for logged-in users
     */
    public function history()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('message', 'Please login to view your rental history.');
        }

        $rentals = BilliardRental::where('user_id', $user->id)
            ->with('billiardTable')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('billiard.history', compact('rentals'));
    }

    /**
     * Calculate price preview via AJAX
     */
    public function calculatePrice(Request $request)
    {
        $validated = $request->validate([
            'duration_hours' => 'required|integer|min:1|max:24',
            'rental_start' => 'nullable|date',
            'table_id' => 'nullable|exists:billiard_tables,id',
        ]);

        $user = Auth::user();
        $isMember = (bool) $user;

        $pricing = BilliardRental::calculatePrice($validated['duration_hours'], $isMember);

        $response = [
            'success' => true,
            'pricing' => $pricing,
            'is_member' => $isMember,
            'formatted' => [
                'price_per_hour' => 'Rp ' . number_format($pricing['price_per_hour'], 0, ',', '.'),
                'subtotal' => 'Rp ' . number_format($pricing['subtotal'], 0, ',', '.'),
                'discount_amount' => 'Rp ' . number_format($pricing['discount_amount'], 0, ',', '.'),
                'total_amount' => 'Rp ' . number_format($pricing['total_amount'], 0, ',', '.'),
            ]
        ];

        // Check availability if rental_start and table_id provided
        if (!empty($validated['rental_start']) && !empty($validated['table_id'])) {
            try {
                $table = BilliardTable::findOrFail($validated['table_id']);
                $rentalStart = Carbon::parse($validated['rental_start']);
                $durationHours = (int) $validated['duration_hours'];
                $rentalEnd = $rentalStart->copy()->addHours($durationHours);

                $isAvailable = $table->isAvailableAt($rentalStart, $rentalEnd);

                $response['available'] = $isAvailable;
                if (!$isAvailable) {
                    $response['message'] = 'Meja tidak tersedia untuk jam yang dipilih. Silakan ubah waktu sewa Anda.';
                }
            } catch (\Exception $e) {
                $response['available'] = false;
                $response['message'] = 'Error checking availability';
            }
        }

        return response()->json($response);
    }

    /**
     * Download receipt PDF
     */
    public function downloadReceipt(BilliardRental $rental)
    {
        $user = Auth::user();

        // Check if user can access this receipt
        if ($rental->user_id && (!$user || $rental->user_id !== $user->id)) {
            abort(403, 'Unauthorized access to receipt');
        }

        if (!$rental->receipt_pdf_path) {
            abort(404, 'Receipt not found');
        }

        return response()->download(
            storage_path('app/public/' . $rental->receipt_pdf_path),
            'receipt-' . $rental->transaction_number . '.pdf'
        );
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, BilliardRental $rental)
    {
        $user = Auth::user();

        // Check if user can access this rental
        if ($rental->user_id && (!$user || $rental->user_id !== $user->id)) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'status' => 'required|in:paid,pending,rejected',
        ]);

        $rental->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui');
    }
}
