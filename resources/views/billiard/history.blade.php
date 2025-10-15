<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />
    <title>Riwayat Pemesanan - {{ config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main class="main max-w-7xl mx-auto py-12 px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold gtbold text-[#1B2B28] mb-2">Riwayat Pemesanan</h1>
                <p class="text-gray-600 gtregular">Lihat semua pemesanan meja billiard Anda</p>
            </div>
            <a href="{{ route('billiard.index') }}"
               class="bg-[#1B2B28] hover:bg-[#701D0D] text-white px-6 py-3 rounded-full font-medium transition-all flex items-center gap-2 gtmedium">
                <i class="ri-add-line"></i>
                Pesan Meja Baru
            </a>
        </div>

        @if($rentals->count() > 0)
            <!-- Summary Statistics -->
            @php
                $totalRentals = $rentals->total();
                $totalSpent = App\Models\BilliardRental::where('user_id', auth()->id())->sum('total_amount');
                $totalSaved = App\Models\BilliardRental::where('user_id', auth()->id())->sum('discount_amount');
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white border border-gray-200 p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 gtregular">Total Pemesanan</h3>
                            <p class="text-2xl font-bold gtbold text-[#1B2B28]">{{ $totalRentals }}</p>
                            <p class="text-xs text-gray-500 gtregular">Sesi billiard</p>
                        </div>
                        <div class="w-12 h-12 bg-[#1B2B28] rounded-full flex items-center justify-center text-white">
                            <i class="ri-calendar-check-line text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 gtregular">Total Pengeluaran</h3>
                            <p class="text-2xl font-bold gtbold text-[#1B2B28]">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 gtregular">Untuk penyewaan billiard</p>
                        </div>
                        <div class="w-12 h-12 bg-[#1B2B28] rounded-full flex items-center justify-center text-white">
                            <i class="ri-money-dollar-circle-line text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 gtregular">Hemat Member</h3>
                            <p class="text-2xl font-bold gtbold text-green-600">Rp {{ number_format($totalSaved, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 gtregular">Dari diskon 10%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white">
                            <i class="ri-vip-crown-fill text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Transaksi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Meja
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rentals as $rental)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                                                <span class="text-xs font-bold gtbold">{{ strtoupper(substr($rental->transaction_number, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 gtbold">
                                                    {{ $rental->transaction_number }}
                                                </div>
                                                <div class="text-sm text-gray-500 gtregular">
                                                    {{ $rental->customer_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="ri-table-line text-gray-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 gtbold">
                                                    Meja {{ $rental->billiardTable->table_number }}
                                                </div>
                                                @if($rental->billiardTable->name)
                                                    <div class="text-sm text-gray-500 gtregular">
                                                        {{ $rental->billiardTable->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1">
                                            <i class="ri-time-line text-gray-400 text-sm"></i>
                                            <span class="text-sm text-gray-900 gtregular">{{ $rental->duration_hours }} jam</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 gtbold">
                                                Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                            </div>
                                            @if($rental->discount_amount > 0)
                                                <div class="text-xs text-green-600 gtmedium flex items-center gap-1">
                                                    <i class="ri-vip-crown-fill text-yellow-500 text-xs"></i>
                                                    -Rp {{ number_format($rental->discount_amount, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium gtmedium
                                            @if($rental->status === 'paid') bg-green-100 text-green-800
                                            @elseif($rental->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            @if($rental->status === 'paid')
                                                <i class="ri-checkbox-circle-fill mr-1"></i> Lunas
                                            @elseif($rental->status === 'rejected')
                                                <i class="ri-close-circle-fill mr-1"></i> Ditolak
                                            @else
                                                <i class="ri-time-fill mr-1"></i> Menunggu
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 gtregular">
                                            {{ $rental->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 gtregular">
                                            {{ $rental->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($rental->receipt_pdf_path)
                                                <a href="{{ route('billiard.receipt.download', $rental) }}"
                                                   class="text-[#1B2B28] hover:text-[#701D0D] gtmedium"
                                                   title="Unduh Struk">
                                                    <i class="ri-download-line text-lg"></i>
                                                </a>
                                            @endif

                                            @if($rental->customer_whatsapp)
                                                @php
                                                    $whatsappService = new App\Services\WhatsAppService();
                                                    $whatsappLink = $whatsappService->getWhatsAppLinkForRental($rental);
                                                @endphp
                                                <a href="{{ $whatsappLink }}" target="_blank" rel="noopener"
                                                   class="text-green-600 hover:text-green-800 gtmedium"
                                                   title="Kirim ke WhatsApp">
                                                    <i class="ri-whatsapp-line text-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 px-6">
                    {{ $rentals->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white border border-gray-200 rounded-lg">
                <div class="text-gray-400 mb-4">
                    <i class="ri-calendar-2-line text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 gtbold">Belum Ada Riwayat Pemesanan</h3>
                <p class="text-gray-500 mb-6 gtregular">Anda belum pernah melakukan pemesanan meja billiard.</p>
                <a href="{{ route('billiard.index') }}"
                   class="bg-[#1B2B28] text-white px-6 py-3 rounded-full gtmedium hover:bg-[#701D0D] transition-all flex items-center gap-2 mx-auto w-fit">
                    <i class="ri-add-line"></i>
                    Pesan Meja Pertama Anda
                </a>
            </div>
        @endif


    </main>

    <x-footer />
</body>
</html>
