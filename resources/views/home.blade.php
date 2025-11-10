<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://steadfast-light-caffe.up.railway.app/build/assets/app-eNwG1Jbd.css" />
</head>

<body class="america overflow-x-hidden">
    <x-navigation />


    <main class="main max-w-7xl mx-auto">
        <section class="hero py-10 relative">
            <div class="flex flex-col items-center justify-center text-center gap-5">
                <h1 class="md:text-7xl text-4xl tracking-[0.14em] md:tracking-[0.18em] leading-snug gardenmedium">
                    START YOUR DAY <br />
                    WITH OUR COFFEE
                </h1>
                <div class="w-full px-4 md:px-10">
                    <div class="w-[100%] mx-auto overflow-hidden h-[20rem] md:h-[45rem]">
                        <div class="w-full h-full relative" id="slide">
                            <img id="img1" src="{{ asset('assets/images/bg-3.JPG') }}" alt="background"
                                class="absolute rounded-lg inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out translate-x-0" />
                            <img id="img2" src="{{ asset('assets/images/bg-4.JPG') }}" alt="background2"
                                class="absolute rounded-lg inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out translate-x-full" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- about -->
        <section class="relative py-0 md:py-12" id="about">
            <div
                class="flex md:flex-row flex-col items-center gap-4 md:gap-0 md:items-start px-10 justify-center md:justify-between">
                <div class="flex flex-col items-center md:items-start gap-4">
                    <p class="max-w-lg tracking-wider text-base md:text-lg gtregular text-[#333333] text-justify">
                        Koloni adalah ruang kreatif berbasis
                        kafe yang menggabungkan kopi
                        berkualitas, sajian Nusantara, dan
                        ruang komunitas yang hangat.
                        Kami hadir bukan hanya untuk
                        menyajikan secangkir kopi terbaik, tapi
                        juga sebagai titik temu bagi para
                        Kolonials; individu dan komunitas
                        yang dinamis, kreatif, dan kolaboratif.
                    </p>
                    <img src="{{ asset('assets/images/kopi.png') }}" alt="kopilate" class="hidden md:block" />
                </div>
                <div class="flex flex-row md:flex-col items-center gap-10 relative">
                    <p class="max-w-sm text-xs md:text-base tracking-wide gtregular text-[#333333e2] text-justify">
                        Dengan biji kopi pilihan dari Tanamera
                        dan makanan Nusantara pilihan,
                        setiap
                        cita
                        rasa
                        di
                        Koloni
                        menghadirkan pengalaman autentik
                        yang membuka percakapan baru, ide
                        besar, hingga peluang kolaborasi.
                    </p>
                    <div
                        class="bg-[#1B2B28] text-[#EAE3D6] rounded-full flex items-center justify-center aspect-square max-w-[14rem] w-full gtbold mx-auto text-center px-6">
                        About Us
                    </div>
                </div>
            </div>
        </section>

        <!-- Page Product -->
        <section class="py-16 md:py-20 relative" id="products">
            <div class="max-w-7xl mx-auto px-4 md:px-10">
                <h1 class="text-3xl md:text-4xl px-4 gtbold text-[#1B2B28] mb-2">Produk Kami</h1>
                <p class="gtregular px-4 text-[#333333] mb-8 max-w-2xl">
                    Nikmati berbagai pilihan makanan dan minuman berkualitas dengan cita rasa yang memanjakan lidah Anda.
                </p>

                <!-- Category Tabs -->
                <div class="flex items-center justify-between py-6 px-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <button
                            class="h-12 w-12 bg-[#1B2B28] text-white rounded-full flex items-center justify-center transition-all hover:bg-[#701D0D] hover:scale-105 category-btn"
                            id="btnfood" data-category="food">
                            <i class="ri-bowl-line text-xl"></i>
                        </button>
                        <button
                            class="h-12 w-12 bg-[#701D0D] text-white rounded-full flex items-center justify-center transition-all hover:bg-[#1B2B28] hover:scale-105 category-btn"
                            id="btndrink" data-category="drink">
                            <i class="ri-drinks-2-line text-xl"></i>
                        </button>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="flex gardenmedium items-center gap-2 border-2 border-[#1B2B28] md:text-sm text-sm text-[#333333] md:px-6 md:py-3 py-2 px-4 rounded-full transition-all hover:bg-[#1B2B28] hover:text-white">
                        <span>Lihat Semua</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

                <!-- Product Slider Container -->
                <div class="relative mt-8 md:mt-12">
                    <!-- Drink Products Carousel -->
                    <div class="product-carousel transition-opacity duration-500 opacity-100" id="carousel-drink">
                        @if(count($drinkProducts) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($drinkProducts as $product)
                            <div class="product-card group bg-white rounded-lg transition-all duration-300 overflow-hidden">
                                <div class="aspect-square overflow-hidden bg-gray-100 relative">
                                    @if($product->photo)
                                    <img
                                        src="{{ asset('storage/' . $product->photo) }}"
                                        alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI0Y5RkFGQiIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzZCNzI4MCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+'" />
                                    @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                            <p class="text-gray-500">No Image</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h5 class="text-lg font-bold text-[#1B2B28] mb-1">{{ $product->title }}</h5>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description ?? 'Nikmati rasa istimewa dari produk pilihan kami' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-[#701D0D]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <!-- <button class="bg-[#1B2B28] text-white px-3 py-1 rounded-full text-sm hover:bg-[#701D0D] transition-colors">
                                            <i class="ri-shopping-cart-line"></i>
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center py-16">
                            <i class="ri-drinks-2-line text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada produk minuman tersedia</p>
                        </div>
                        @endif
                    </div>

                    <!-- Food Products Carousel -->
                    <div class="product-carousel transition-opacity duration-500 opacity-0 pointer-events-none absolute inset-0" id="carousel-food">
                        @if(count($foodProducts) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($foodProducts as $product)
                            <div class="product-card group bg-white rounded-lg transition-all duration-300 overflow-hidden">
                                <div class="aspect-square overflow-hidden bg-gray-100 relative">
                                    @if($product->photo)
                                    <img
                                        src="{{ asset('storage/' . $product->photo) }}"
                                        alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI0Y5RkFGQiIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzZCNzI4MCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+'" />
                                    @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                            <p class="text-gray-500">No Image</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h5 class="text-lg font-bold text-[#1B2B28] mb-1">{{ $product->title }}</h5>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description ?? 'Nikmati rasa istimewa dari produk pilihan kami' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-[#701D0D]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <!-- <button class="bg-[#1B2B28] text-white px-3 py-1 rounded-full text-sm hover:bg-[#701D0D] transition-colors">
                                            <i class="ri-shopping-cart-line"></i>
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center py-16">
                            <i class="ri-bowl-line text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada produk makanan tersedia</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Page Billiard -->

        <section class="garden py-10 md:overflow-visible overflow-x-hidden" id="billiard">
            <h1 class="text-3xl px-4 gtbold py-6">Billiard Rental</h1>
            <div class="relative max-w-6xl mx-auto px-4">
                <!-- Background Image -->
                <div class="relative h-[400px] rounded-xl overflow-hidden">
                    <img src="{{ asset('assets/images/background-billard.png') }}" alt="background"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>


                <!-- Content Container -->
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full max-w-6xl mx-auto px-8 md:px-12 flex items-center justify-between">
                        <!-- Text Content - Left Side -->
                        <div class="flex flex-col justify-center text-left text-white max-w-md z-10">
                            <h1 class="text-lg sm:text-2xl md:text-3xl mb-3 md:mb-4">Main Billiard Seru Bareng
                                Teman!</h1>
                            <p class="text-xs sm:text-sm md:text-base mb-4 md:mb-6 leading-relaxed">
                                Nikmati permainan billiard seru hanya dengan
                                <br>
                                <span class="text-base sm:text-xl md:text-2xl font-semibold tracking-wide">Rp
                                    120.000</span>/jam.
                                <br>Cocok buat hangout bareng teman atau latihan serius!
                            </p>
                            <a id="bookBtn" href="{{ route('billiard.index') }}"
                                class="bg-white cursor-pointer text-black font-semibold text-xs md:text-sm w-fit px-6 py-3 md:px-8 md:py-4 rounded-2xl hover:bg-gray-200 transition">
                                Booking Sekarang
                            </a>
                        </div>

                        <!-- Billiard Table Image - Right Side (Overflow Visible di Desktop) -->
                        <div class="absolute right-0 top-[60%] md:top-1/2 -translate-y-1/2 pointer-events-none">
                            <img src="{{ asset('assets/images/Billiard-Table-PNG-Photos 1.png') }}" alt="mejabillard"
                                class="w-[280px] sm:w-[320px] md:w-[450px] lg:w-[550px] drop-shadow-2xl translate-x-8 sm:translate-x-16 md:translate-x-24 lg:translate-x-32">
                        </div>
                    </div>
                </div>
            </div>

            <div id="formbillard" class="bg-red-500 w-full h-[200px] relative z-[9999] hidden">
            </div>
        </section>

        <!-- contact -->

        <section id="contact" class="py-12">
            <div class="max-w-7xl mx-auto px-0">
                <div class="flex flex-col md:flex-row gap-8">
                    <form class="flex-1 p-6 flex flex-col gap-4">
                        <h1 class="text-3xl gtbold text-left">Contact</h1>
                        <input type="text" id="name" name="name" placeholder="Name"
                            class="border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28]" />
                        <input type="tel" id="wa" name="wa" placeholder="No wa"
                            class="border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28]" />
                        <textarea id="message" name="message" rows="5" placeholder="Massage"
                            class="border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] resize-none"></textarea>

                        <button type="submit"
                            class="bg-[#1B2B28] text-white font-semibold py-3 rounded-md cursor-pointer hover:bg-[#333333] transition-colors">
                            Kirim Pesan
                        </button>
                    </form>

                    <div class="flex-1 rounded-lg overflow-hidden mt-10 md:h-[400px] h-[200px]">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.123456789!2d106.816666!3d-6.200000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zTWFwIFNhbXBsZSBHZW9ncmFwaHk!5e0!3m2!1sid!2sid!4v1234567890"
                            class="w-full h-full border-0 px-4 md:px-0" style="border: 0" allowfullscreen=""
                            loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

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



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Product category toggle functionality
            const btnfood = document.getElementById("btnfood");
            const btndrink = document.getElementById("btndrink");
            const carouselDrink = document.getElementById("carousel-drink");
            const carouselFood = document.getElementById("carousel-food");

            if (btnfood && btndrink && carouselDrink && carouselFood) {
                btnfood.addEventListener("click", () => {
                    // Update button styles
                    btnfood.classList.remove("bg-[#701D0D]");
                    btnfood.classList.add("bg-[#1B2B28]");
                    btndrink.classList.remove("bg-[#1B2B28]");
                    btndrink.classList.add("bg-[#701D0D]");

                    // Toggle carousels
                    carouselDrink.classList.add("opacity-0", "pointer-events-none");
                    carouselFood.classList.remove("opacity-0", "pointer-events-none");
                });

                btndrink.addEventListener("click", () => {
                    // Update button styles
                    btndrink.classList.remove("bg-[#701D0D]");
                    btndrink.classList.add("bg-[#1B2B28]");
                    btnfood.classList.remove("bg-[#1B2B28]");
                    btnfood.classList.add("bg-[#701D0D]");

                    // Toggle carousels
                    carouselFood.classList.add("opacity-0", "pointer-events-none");
                    carouselDrink.classList.remove("opacity-0", "pointer-events-none");
                });
            }

            // Background slideshow functionality
            const img1 = document.getElementById("img1");
            const img2 = document.getElementById("img2");

            if (img1 && img2) {
                let currentImage = 1;

                setInterval(() => {
                    if (currentImage === 1) {
                        img1.classList.add("translate-x-full");
                        img1.classList.remove("translate-x-0");
                        img2.classList.remove("translate-x-full");
                        img2.classList.add("translate-x-0");
                        currentImage = 2;
                    } else {
                        img2.classList.add("translate-x-full");
                        img2.classList.remove("translate-x-0");
                        img1.classList.remove("translate-x-full");
                        img1.classList.add("translate-x-0");
                        currentImage = 1;
                    }
                }, 5000); // Change image every 5 seconds
            }
        });
    </script>

</body>

</html>