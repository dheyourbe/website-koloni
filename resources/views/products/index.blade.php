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

    <main class="main max-w-7xl mx-auto py-12">
        <!-- Header Section -->
        <section class="text-center mb-12">
            <h1 class="md:text-5xl text-3xl tracking-[0.14em] md:tracking-[0.18em] leading-snug gardenmedium mb-4">
                PRODUK KAMI
            </h1>
            <p class="max-w-2xl mx-auto gtregular text-[#333333] text-lg">
                Nikmati berbagai pilihan makanan dan minuman berkualitas tinggi yang disajikan dengan cita rasa terbaik.
            </p>
        </section>

        <!-- Category Tabs -->
        <section class="mb-12">
            <div class="flex justify-center">
                <div class="inline-flex rounded-full border-2 border-[#1B2B28] p-1">
                    <button
                        id="food-tab"
                        class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-300 {{ $category == 'makanan' ? 'bg-[#701D0D] text-white' : 'text-[#333333]' }}"
                        onclick="switchCategory('makanan')">
                        <i class="ri-bowl-line mr-2"></i>
                        Makanan
                    </button>
                    <button
                        id="drink-tab"
                        class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-300 {{ $category == 'minuman' ? 'bg-[#701D0D] text-white' : 'text-[#333333]' }}"
                        onclick="switchCategory('minuman')">
                        <i class="ri-drinks-2-line mr-2"></i>
                        Minuman
                    </button>
                </div>
            </div>
        </section>

        <!-- Products Grid -->
        <section class="px-4 md:px-10">
            <!-- Food Products -->
            <div id="food-products" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $category == 'makanan' ? '' : 'hidden' }}">
                @forelse ($foodProducts as $product)
                <div class="bg-white rounded-lg overflow-hidden">
                    <div class="h-64 overflow-hidden bg-gray-100 relative">
                        @if($product->photo)
                        <img
                            src="{{ asset('storage/' . $product->photo) }}"
                            alt="{{ $product->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center" style="display: none;">
                            <div class="text-center">
                                <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">No Image</p>
                            </div>
                        </div>
                        @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <div class="text-center">
                                <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">No Image</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold gtbold mb-2">{{ $product->title }}</h3>
                        <p class="text-gray-600 gtregular mb-4 line-clamp-3">{{ $product->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-[#1B2B28]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <!-- <button class="bg-[#1B2B28] text-white px-4 py-2 rounded-full hover:bg-[#333333] transition-colors">
                                    <i class="ri-add-line"></i>
                                </button> -->
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="ri-bowl-line text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500">Belum ada produk makanan tersedia</p>
                </div>
                @endforelse
            </div>

            <!-- Drink Products -->
            <div id="drink-products" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $category == 'minuman' ? '' : 'hidden' }}">
                @forelse ($drinkProducts as $product)
                <div class="bg-white rounded-lg overflow-hidden">
                    <div class="h-64 overflow-hidden bg-gray-100 relative">
                        @if($product->photo)
                        <img
                            src="{{ asset('storage/' . $product->photo) }}"
                            alt="{{ $product->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center" style="display: none;">
                            <div class="text-center">
                                <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">No Image</p>
                            </div>
                        </div>
                        @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <div class="text-center">
                                <i class="ri-image-line text-6xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">No Image</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold gtbold mb-2">{{ $product->title }}</h3>
                        <p class="text-gray-600 gtregular mb-4 line-clamp-3">{{ $product->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-[#1B2B28]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <!-- <button class="bg-[#1B2B28] text-white px-4 py-2 rounded-full hover:bg-[#333333] transition-colors">
                                <i class="ri-add-line"></i>
                            </button> -->
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="ri-drinks-2-line text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500">Belum ada produk minuman tersedia</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>

    <x-footer />

    <script>
        function switchCategory(category) {
            // Update URL with category parameter
            const url = new URL(window.location);
            url.searchParams.set('category', category);
            window.history.pushState({}, '', url);

            // Update tab buttons
            const foodTab = document.getElementById('food-tab');
            const drinkTab = document.getElementById('drink-tab');
            const foodProducts = document.getElementById('food-products');
            const drinkProducts = document.getElementById('drink-products');

            if (category === 'makanan') {
                foodTab.classList.add('bg-[#1B2B28]', 'text-white');
                foodTab.classList.remove('text-[#333333]');
                drinkTab.classList.remove('bg-[#701D0D]', 'text-white');
                drinkTab.classList.add('text-[#333333]');

                foodProducts.classList.remove('hidden');
                drinkProducts.classList.add('hidden');
            } else {
                drinkTab.classList.add('bg-[#701D0D]', 'text-white');
                drinkTab.classList.remove('text-[#333333]');
                foodTab.classList.remove('bg-[#1B2B28]', 'text-white');
                foodTab.classList.add('text-[#333333]');

                drinkProducts.classList.remove('hidden');
                foodProducts.classList.add('hidden');
            }
        }
    </script>
</body>

</html>