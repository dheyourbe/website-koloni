<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />
    <title>Meja Billiard - {{ config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main class="main max-w-7xl mx-auto py-12">
        <div class="px-4 md:px-10">
            <!-- Table Selection Section -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold gtbold text-[#1B2B28] mb-2">Pilih Meja Anda</h2>
                        <p class="gtregular text-[#333333]">
                            Pilih meja untuk memulai penyewaan billiard Anda.
                            @auth
                            <span class="text-green-600 font-medium gtmedium">Sebagai member, Anda dapatkan diskon 10%!</span>
                            @else
                            <span class="text-blue-600 gtmedium">Login untuk dapatkan diskon member 10%!</span>
                            @endauth
                        </p>
                    </div>
                </div>
            </div>

            @if($tables->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tables as $table)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-[#1B2B28] transition-all">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 gtbold">
                                    {{ $table->name ?: 'Meja ' . $table->table_number }}
                                </h4>
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <i class="ri-price-tag-3-line mr-1"></i>
                                    <span class="gtregular">{{ $table->table_number }}</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-[#1B2B28] rounded-full flex items-center justify-center text-white">
                                <i class="ri-table-line text-xl"></i>
                            </div>
                        </div>

                        @if($table->description)
                        <p class="text-sm text-gray-600 mb-4 gtregular">{{ $table->description }}</p>
                        @endif

                        <!-- Table occupancy status temporarily disabled
                                @if($table->isOccupied())
                                    <div class="bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-md text-sm font-medium mb-4 flex items-center gap-2">
                                        <i class="ri-time-line"></i>
                                        Sedang Digunakan
                                    </div>
                                @endif
                                -->

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500 gtregular">Tarif Normal</span>
                                    <div class="text-lg font-bold text-[#1B2B28] gtbold">Rp 120.000</div>
                                    <div class="text-xs text-gray-500 gtregular">per jam</div>
                                </div>

                                @auth
                                <div class="text-right">
                                    <span class="text-xs text-green-600 gtregular">Harga Member</span>
                                    <div class="text-lg font-bold text-green-600 gtbold">Rp 108.000</div>
                                    <div class="text-xs text-green-600 gtregular">per jam</div>
                                </div>
                                @endauth
                            </div>

                            <a href="{{ route('billiard.book', $table) }}"
                                class="w-full bg-[#1B2B28] hover:bg-[#701D0D] text-white px-4 py-3 rounded-full text-sm font-medium transition-all flex items-center justify-center gap-2 gtmedium">
                                <i class="ri-calendar-check-line"></i>
                                Pesan Meja Ini
                            </a>

                            <!-- Original button with occupancy check (temporarily disabled)
                                    <a href="{{ route('billiard.book', $table) }}"
                                       class="w-full bg-[#1B2B28] hover:bg-[#701D0D] text-white px-4 py-3 rounded-full text-sm font-medium transition-all flex items-center justify-center gap-2 gtmedium {{ $table->isOccupied() ? 'opacity-50 cursor-not-allowed bg-gray-400' : '' }}"
                                       @if($table->isOccupied()) onclick="return false;" @endif>
                                        @if($table->isOccupied())
                                            <i class="ri-close-circle-line"></i>
                                            Tidak Tersedia
                                        @else
                                            <i class="ri-calendar-check-line"></i>
                                            Pesan Meja Ini
                                        @endif
                                    </a>
                                    -->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white border border-gray-200 rounded-lg">
                <div class="text-gray-400 mb-4">
                    <i class="ri-table-line text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 gtbold">Belum Ada Meja Tersedia</h3>
                <p class="text-gray-500 mb-6 gtregular">Meja billiard akan muncul di sini setelah ditambahkan oleh admin.</p>
                <a href="{{ route('billiard') }}"
                    class="bg-[#1B2B28] text-white px-6 py-3 rounded-full gtmedium hover:bg-[#701D0D] transition-all flex items-center gap-2 mx-auto w-fit">
                    <i class="ri-customer-service-2-line"></i>
                    Hubungi Kami
                </a>
            </div>
            @endif

            <!-- Information Section -->
            <div class="mt-12 bg-white border border-gray-200 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-time-line"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 gtbold mb-1">Jam Operasional</h3>
                            <p class="text-sm text-gray-600 gtregular">Setiap hari: 10:00 - 22:00 WIB</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-percent-line"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 gtbold mb-1">Diskon Member</h3>
                            <p class="text-sm text-gray-600 gtregular">Dapatkan diskon 10% untuk semua pemesanan</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-[#1B2B28] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="ri-phone-line"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 gtbold mb-1">Reservasi</h3>
                            <p class="text-sm text-gray-600 gtregular">Hubungi +62 812 3456 7890 untuk reservasi</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="ri-information-line"></i>
                        <span class="gtregular">Pembayaran dapat dilakukan secara tunai atau transfer saat datang</span>
                    </div>

                    @auth
                    <a href="{{ route('billiard.history') }}"
                        class="text-[#1B2B28] hover:text-[#701D0D] text-sm font-medium flex items-center gap-2 gtmedium">
                        <i class="ri-history-line"></i>
                        Lihat Riwayat Pemesanan
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="text-[#1B2B28] hover:text-[#701D0D] text-sm font-medium flex items-center gap-2 gtmedium">
                        <i class="ri-login-box-line"></i>
                        Login untuk lihat riwayat
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>