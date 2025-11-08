<footer class="garden text-white">
    <div class="bg-[#1B2B28] max-w-[1600px] mx-auto py-4 px-6 md:px-10">
        <div
            class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6 border-b border-gray-700 pb-4">
            <!-- Kolom Kiri -->
            <div class="flex flex-col gap-1 text-center md:text-left w-full md:w-1/3">
                <h3 class="gtbold text-base md:text-lg mb-1">Alamat</h3>
                <p class="text-xs md:text-sm leading-snug">
                    Komplek Perkantoran Marinatama, Jl. Mangga Dua Raya Jl. Gn. Sahari
                    No.2 Blok C No. 1-3, Pademangan Bar., Kec. Pademangan, Jkt Utara,
                    Daerah Khusus Ibukota Jakarta 14440
                </p>
                <p class="text-xs md:text-sm leading-snug">Telp: +62 812 3456 7890</p>
                <p class="text-xs md:text-sm leading-snug">Email: info@coffeeshop.com</p>
            </div>

            <!-- Kolom Tengah (Logo) -->
            <div class="flex flex-col items-center justify-center w-full md:w-1/3">
                <img
                    src="{{ asset('assets/images/Logo 1 1.png') }}"
                    alt="Logo"
                    class="h-20 object-contain mb-1" />
                <p class="text-xs text-gray-300 mt-1">Koloni Coffee</p>
            </div>

            <!-- Kolom Kanan (Info Coffee + Instagram) -->
            <div class="flex flex-col items-center md:items-end gap-2 w-full md:w-1/3">
                <h3 class="gtbold text-base md:text-lg mb-1">Info Coffee</h3>
                <p class="text-xs md:text-sm leading-snug">Follow kami di Instagram</p>

                <!-- Link Instagram -->
                <a
                    href="https://www.instagram.com/kolonicafepool/"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center justify-center md:justify-end gap-2 text-xs md:text-sm text-gray-300 hover:text-[#c0a080] transition">
                    <!-- Ikon Instagram (SVG) -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3zm9 4.5h.008v.008H16.5V7.5zM12 9a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                    @kolonicafepool
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div
            class="max-w-6xl mx-auto flex flex-col md:flex-row justify-center items-center pt-3 text-gray-300 text-xs md:text-sm text-center">
            <p>© 2025 KoloniCoffee. All Rights Reserved.</p>
        </div>
    </div>
</footer>