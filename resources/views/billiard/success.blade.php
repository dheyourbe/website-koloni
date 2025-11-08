<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://steadfast-light-caffe.up.railway.app/build/assets/app-oxxngOD7.css" />
    <title>Pemesanan Berhasil - {{ config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main class="main max-w-4xl mx-auto py-12 px-4">
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                <i class="ri-checkbox-circle-fill text-4xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold gtbold text-[#1B2B28] mb-2">🎱 Pemesanan Berhasil!</h1>
            <p class="text-gray-600 gtregular">Meja billiard Anda telah berhasil dipesan.</p>
        </div>

        <!-- Booking Details -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold gtbold text-[#1B2B28] mb-4 flex items-center gap-2">
                <i class="ri-file-list-3-line"></i>
                Detail Pemesanan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-hashtag text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Nomor Transaksi</p>
                            <p class="text-lg font-semibold gtbold text-gray-900">{{ $rental->transaction_number }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-table-line text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Meja</p>
                            <p class="text-lg font-semibold gtbold text-gray-900">Meja {{ $rental->billiardTable->table_number }}</p>
                            @if($rental->billiardTable->name)
                            <p class="text-sm text-gray-600 gtregular">{{ $rental->billiardTable->name }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-user-line text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Nama Pelanggan</p>
                            <p class="text-lg font-semibold gtbold text-gray-900">{{ $rental->customer_name }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-time-line text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Durasi</p>
                            <p class="text-lg font-semibold gtbold text-gray-900">{{ $rental->duration_hours }} jam</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-money-dollar-circle-line text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Total Pembayaran</p>
                            <p class="text-2xl font-bold gtbold text-[#1B2B28]">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</p>
                            @if($rental->discount_amount > 0)
                            <p class="text-sm text-green-600 gtmedium flex items-center gap-1">
                                <i class="ri-vip-crown-fill text-yellow-500"></i>
                                Hemat Rp {{ number_format($rental->discount_amount, 0, ',', '.') }} (diskon member)
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-information-line text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 gtregular">Status</p>
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
                                <i class="ri-time-fill mr-1"></i> Menunggu Pembayaran
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================================================================== -->
        <!-- [AWAL BLOK BARU] Tampil Hanya Jika Menunggu Pembayaran -->
        <!-- ===================================================================== -->
        @if($rental->status === 'pending')

        <!-- Payment Status Info (Blok Biru yang sudah ada) -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                    <i class="ri-information-line text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium gtbold text-blue-800 mb-1">Pembayaran Menunggu Konfirmasi</h3>
                    <p class="text-sm text-blue-700 gtregular">
                        Pemesanan Anda telah dikonfirmasi, namun pembayaran masih menunggu verifikasi dari admin. Admin akan memverifikasi pembayaran Anda dan memperbarui status sesegera mungkin.
                    </p>
                </div>
            </div>
        </div>

        <!-- [BARU] Petunjuk Pembayaran & Link WA Admin -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold gtbold text-[#1B2B28] mb-5 flex items-center gap-2">
                <i class="ri-bank-card-line"></i>
                Petunjuk Pembayaran
            </h2>
            <p class="text-sm text-gray-600 gtregular mb-4">
                Silakan lakukan transfer ke rekening berikut untuk menyelesaikan pemesanan Anda:
            </p>

            {{-- !!! GANTI DETAIL BANK DI BAWAH INI !!! --}}
            <div class="space-y-3 border border-gray-100 bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 gtregular">Bank</span>
                    <span class="text-lg font-semibold gtbold text-gray-900">BCA (Contoh)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 gtregular">Nomor Rekening</span>
                    <span class="text-lg font-semibold gtbold text-gray-900">123-456-7890</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 gtregular">Atas Nama</span>
                    <span class="text-lg font-semibold gtbold text-gray-900">PT. Koloni Billiard</span>
                </div>
                <hr class="!my-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 gtregular">Nominal Transfer</span>
                    <span class="text-2xl font-bold gtbold text-[#1B2B28]">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <p class="text-xs text-gray-500 gtregular mt-3 text-center">
                *Harap transfer sesuai dengan nominal total untuk kemudahan verifikasi.
            </p>

            <hr class="my-6 border-gray-100">

            {{-- [BARU] Logika untuk Link WA Admin --}}
            @php
            // !!! PENTING: Ganti nomor WhatsApp admin di sini (format 62)
            $adminWhatsapp = '6287820497032'; // <-- GANTI INI

                $message="Halo Admin, saya ingin konfirmasi pembayaran untuk booking billiard:\n\n" . "No. Transaksi: " . $rental->transaction_number . "\n" .
                "Nama: " . $rental->customer_name . "\n" .
                "Total: Rp " . number_format($rental->total_amount, 0, ',', '.') . "\n\n" .
                "Berikut saya lampirkan bukti transfer. Terima kasih.";

                $whatsappConfirmUrl = 'https://wa.me/' . $adminWhatsapp . '?text=' . urlencode($message);
                @endphp

                <p class="text-sm text-gray-600 gtregular mb-3 text-center">
                    Setelah melakukan transfer, silakan kirim bukti pembayaran Anda ke Admin:
                </p>

                <!-- [BARU] Tombol WA Admin -->
                <a href="{{ $whatsappConfirmUrl }}" target="_blank" rel="noopener"
                    class="flex items-center justify-center w-full gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-medium transition-all gtmedium">
                    <i class="ri-whatsapp-line"></i>
                    Kirim Bukti Pembayaran ke Admin
                </a>
        </div>

        @endif
        <!-- ===================================================================== -->
        <!-- [AKHIR BLOK BARU] -->
        <!-- ===================================================================== -->


        <!-- WhatsApp Receipt (Blok Hijau yang sudah ada) -->
        @if($rental->customer_whatsapp && $whatsappLink)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                    <i class="ri-whatsapp-line text-sm"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium gtbold text-green-800 mb-1">Struk Dikirim ke Pelanggan</h3>
                    <p class="text-sm text-green-700 gtregular mb-2">
                        Struk pembayaran telah dikirim ke WhatsApp Anda: {{ $rental->customer_whatsapp }}
                    </p>
                    <a href="{{ $whatsappLink }}" target="_blank" rel="noopener"
                        class="inline-flex items-center text-sm font-medium text-green-700 hover:text-green-800 gtmedium">
                        <i class="ri-external-link-line mr-1"></i>
                        Buka WhatsApp
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            @if($rental->receipt_pdf_path)
            <a href="{{ route('billiard.receipt.download', $rental) }}"
                class="flex items-center justify-center gap-2 border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-full font-medium transition-all hover:bg-gray-50 gtmedium">
                <i class="ri-download-line"></i>
                Unduh Struk (PDF)
            </a>
            @endif

            @auth
            <a href="{{ route('billiard.history') }}"
                class="flex items-center justify-center gap-2 bg-[#1B2B28] hover:bg-[#701D0D] text-white px-6 py-3 rounded-full font-medium transition-all gtmedium">
                <i class="ri-history-line"></i>
                Lihat Riwayat Saya
            </a>
            @endauth

            <a href="{{ route('billiard.index') }}"
                class="flex items-center justify-center gap-2 border-2 border-[#1B2B28] text-[#1B2B28] px-6 py-3 rounded-full font-medium transition-all hover:bg-[#1B2B28] hover:text-white gtmedium">
                <i class="ri-add-line"></i>
                Pesan Meja Lain
            </a>
        </div>

        <!-- Contact Info -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold gtbold text-[#1B2B28] mb-4 flex items-center gap-2">
                <i class="ri-customer-service-2-line"></i>
                Butuh Bantuan?
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                        <i class="ri-phone-line text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium gtbold text-gray-900">Hubungi Kami</p>
                        <p class="text-sm text-gray-600 gtregular">+62 812 3456 7890</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">

                    <div>
                        <a href="https://maps.app.goo.gl/2Kjvh8MfKZBZUPS96"
                            target="_blank"
                            rel="noopener"
                            class="flex items-start gap-3 transition-opacity hover:opacity-80">
                            <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="ri-map-pin-line text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium gtbold text-gray-900">Kunjungi Lokasi</p>
                                {{-- !!! GANTI ALAMAT DI SINI !!! --}}
                                <p class="text-sm text-gray-600 gtregular">123 Coffee Street</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 gtregular mb-2">
                    Terima kasih telah memilih KOLONI Coffee Billiard!
                </p>
                <p class="text-xs text-gray-500 gtregular">
                    Ini adalah pemesanan komputer yang telah dikonfirmasi secara otomatis.
                </p>
            </div>
        </div>
    </main>


    <x-footer />
</body>

</html>