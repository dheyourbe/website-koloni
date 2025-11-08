<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://steadfast-light-caffe.up.railway.app/build/assets/app-oxxngOD7.css" />
    <title>Pesan Meja Billiard - {{ config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main class="main max-w-4xl mx-auto py-12 px-4">
        <!-- Header Section -->
        <div class="text-center mb-8">

            <h1 class="text-3xl font-bold gtbold text-[#1B2B28] mb-2">Pesan Meja Billiard</h1>
            <p class="text-gray-600 gtregular">Lengkapi formulir di bawah untuk memesan meja billiard favorit Anda</p>
        </div>

        <!-- Pricing Information -->
        <div class="bg-[#1B2B28] text-white p-6 rounded-lg mb-8">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-lg gtbold flex items-center gap-2">
                    <i class="ri-price-tag-3-line"></i>
                    Informasi Harga
                </h4>
                <div class="flex items-center gap-2">
                    <i class="ri-time-line"></i>
                    <span class="text-sm gtregular">Jam Operasional: 10:00 - 22:00 WIB</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white/10 p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm gtregular opacity-90">Tarif Normal</p>
                            <p class="text-xl font-bold gtbold">Rp 120.000</p>
                            <p class="text-xs gtregular opacity-75">per jam</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ri-money-dollar-circle-line text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 p-4 rounded-lg">
                    @auth
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm gtregular opacity-90 flex items-center gap-1">
                                <i class="ri-vip-crown-fill text-yellow-400"></i>
                                Harga Member
                            </p>
                            <p class="text-xl font-bold gtbold">Rp 108.000</p>
                            <p class="text-xs gtregular opacity-75">per jam (hemat 10%)</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ri-gift-line text-xl text-yellow-400"></i>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm gtregular opacity-90">Belum Member?</p>
                            <p class="text-lg font-medium gtbold">Dapatkan Diskon 10%</p>
                            <p class="text-xs gtregular opacity-75">Daftar sekarang!</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ri-user-add-line text-xl"></i>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            @guest
            <div class="bg-yellow-400/20 border border-yellow-400/30 rounded-md p-3 mt-4 flex items-center gap-3">
                <i class="ri-lightbulb-line text-yellow-400 text-xl"></i>
                <p class="text-sm gtregular">
                    <span class="font-medium gtbold">💡 Hemat Uang!</span>
                    <a href="{{ route('register') }}" class="underline font-medium text-yellow-300 hover:text-yellow-200">Daftar gratis</a>
                    atau
                    <a href="{{ route('login') }}" class="underline font-medium text-yellow-300 hover:text-yellow-200">login</a>
                    untuk dapatkan diskon 10% untuk semua pemesanan billiard!
                </p>
            </div>
            @endguest
        </div>

        <!-- Booking Form -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <form action="{{ route('billiard.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="billiard_table_id" value="" id="selectedTableId">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Table Selection -->
                    <div>
                        <label for="table_select" class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <i class="ri-table-line text-[#1B2B28]"></i>
                            Pilih Meja Billiard
                        </label>
                        <select id="table_select" name="table_select" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] focus:border-[#1B2B28] gtregular"
                            onchange="updateSelectedTable()">
                            <option value="">Pilih meja...</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}"
                                data-name="{{ $table->name ?: $table->table_number }}"
                                data-number="{{ $table->table_number }}"
                                {{ $selectedTable && $selectedTable->id == $table->id ? 'selected' : '' }}>
                                Meja {{ $table->table_number }} {{ $table->name ? '- ' . $table->name : '' }}
                            </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 gtregular">Pilih meja yang ingin Anda pesan</p>
                        @error('billiard_table_id')
                        <p class="mt-1 text-sm text-red-600 gtregular">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <i class="ri-user-line text-[#1B2B28]"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" id="customer_name" name="customer_name"
                            value="{{ old('customer_name', $user?->name) }}" required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] focus:border-[#1B2B28] gtregular">
                        @error('customer_name')
                        <p class="mt-1 text-sm text-red-600 gtregular">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label for="customer_whatsapp" class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <i class="ri-whatsapp-line text-[#1B2B28]"></i>
                            Nomor WhatsApp
                            <span class="text-gray-500 text-xs gtregular">(untuk bukti pembayaran)</span>
                        </label>
                        <input type="text" id="customer_whatsapp" name="customer_whatsapp"
                            value="{{ old('customer_whatsapp', $user?->no_wa) }}"
                            placeholder="contoh: 08123456789"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] focus:border-[#1B2B28] gtregular">
                        <p class="mt-1 text-xs text-gray-500 gtregular">Struk pembayaran akan dikirim ke nomor ini</p>
                        @error('customer_whatsapp')
                        <p class="mt-1 text-sm text-red-600 gtregular">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rental Start Time -->
                    <div>
                        <label for="rental_start" class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <i class="ri-calendar-line text-[#1B2B28]"></i>
                            Waktu Mulai Sewa
                        </label>
                        <input type="datetime-local" id="rental_start" name="rental_start"
                            value="{{ old('rental_start', now()->addHour()->format('Y-m-d\TH:i')) }}" required
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] focus:border-[#1B2B28] gtregular"
                            onchange="checkAvailability()">
                        <p class="mt-1 text-xs text-gray-500 gtregular">Pilih waktu ketika Anda ingin mulai bermain</p>
                        @error('rental_start')
                        <p class="mt-1 text-sm text-red-600 gtregular">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_hours" class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                            <i class="ri-time-line text-[#1B2B28]"></i>
                            Durasi Sewa (Jam)
                        </label>
                        <select id="duration_hours" name="duration_hours" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B2B28] focus:border-[#1B2B28] gtregular"
                            onchange="calculatePrice(); checkAvailability();">
                            <option value="">Pilih durasi...</option>
                            @for($i = 1; $i <= 24; $i++)
                                <option value="{{ $i }}" {{ old('duration_hours') == $i ? 'selected' : '' }}>
                                {{ $i }} jam
                                </option>
                                @endfor
                        </select>
                        @error('duration_hours')
                        <p class="mt-1 text-sm text-red-600 gtregular">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Availability Status -->
                <div id="availabilityStatus" class="mt-6" style="display: none;"></div>

                <!-- Price Calculation -->
                <div class="mt-8 bg-gray-50 border border-gray-200 p-6 rounded-lg" id="priceCalculation" style="display: none;">
                    <h4 class="font-medium text-gray-900 mb-4 flex items-center gap-2 gtbold">
                        <i class="ri-calculator-line text-[#1B2B28]"></i>
                        Rincian Biaya
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 gtregular">Harga per jam:</span>
                            <span id="pricePerHour" class="font-medium gtbold">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 gtregular">Subtotal:</span>
                            <span id="subtotal" class="font-medium gtbold">-</span>
                        </div>
                        <div class="flex justify-between items-center" id="discountRow" style="display: none;">
                            <span class="text-green-600 gtmedium flex items-center gap-1">
                                <i class="ri-vip-crown-fill text-yellow-500"></i>
                                Diskon Member (10%):
                            </span>
                            <span class="text-green-600 font-medium gtbold" id="discount">-</span>
                        </div>
                        <div class="border-t border-gray-300 pt-3 flex justify-between items-center">
                            <span class="text-lg font-bold text-[#1B2B28] gtbold">Total Pembayaran:</span>
                            <span id="totalAmount" class="text-xl font-bold text-[#1B2B28] gtbold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex items-start gap-3">
                        <i class="ri-error-warning-line text-red-400 text-xl flex-shrink-0 mt-0.5"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800 gtbold mb-2">Perbaiki kesalahan berikut:</h3>
                            <div class="text-sm text-red-700 gtregular">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('billiard.index') }}"
                        class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-full font-medium transition-all hover:bg-gray-50 flex items-center justify-center gap-2 gtmedium">
                        <i class="ri-arrow-left-line"></i>
                        Kembali
                    </a>
                    <button type="submit" id="payButton"
                        class="bg-[#1B2B28] hover:bg-[#701D0D] text-white px-6 py-3 rounded-full font-medium transition-all flex items-center justify-center gap-2 gtmedium disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <i class="ri-shopping-cart-line"></i>
                        Pesan & Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>

    </main>

    <x-footer />

    <script>
        let availabilityTimer = null;

        function updateSelectedTable() {
            const tableSelect = document.getElementById('table_select');
            const selectedTableId = document.getElementById('selectedTableId');

            selectedTableId.value = tableSelect.value;

            // Reset price calculation and availability when table changes
            const priceCalculation = document.getElementById('priceCalculation');
            const availabilityStatus = document.getElementById('availabilityStatus');
            const payButton = document.getElementById('payButton');

            priceCalculation.style.display = 'none';
            availabilityStatus.style.display = 'none';
            payButton.disabled = true;

            // Recalculate if duration is already selected
            const duration = document.getElementById('duration_hours').value;
            if (duration && tableSelect.value) {
                calculatePrice();
            }
        }

        function calculatePrice() {
            const durationSelect = document.getElementById('duration_hours');
            const duration = parseInt(durationSelect.value);
            const payButton = document.getElementById('payButton');
            const priceCalculation = document.getElementById('priceCalculation');

            if (!duration) {
                priceCalculation.style.display = 'none';
                payButton.disabled = true;
                return;
            }

            fetch('{{ route('billiard.calculate-price') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            duration_hours: duration
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('pricePerHour').textContent = data.formatted.price_per_hour;
                        document.getElementById('subtotal').textContent = data.formatted.subtotal;
                        document.getElementById('totalAmount').textContent = data.formatted.total_amount;

                        const discountRow = document.getElementById('discountRow');
                        if (data.is_member && data.pricing.discount_amount > 0) {
                            document.getElementById('discount').textContent = '- ' + data.formatted.discount_amount;
                            discountRow.style.display = 'flex';
                        } else {
                            discountRow.style.display = 'none';
                        }

                        priceCalculation.style.display = 'block';
                        // Don't enable button yet, check availability first
                        checkAvailability();
                    } else {
                        priceCalculation.style.display = 'none';
                        payButton.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error calculating price:', error);
                    priceCalculation.style.display = 'none';
                    payButton.disabled = true;
                });
        }

        function checkAvailability() {
            const rentalStart = document.getElementById('rental_start').value;
            const duration = document.getElementById('duration_hours').value;
            const tableId = document.getElementById('selectedTableId').value;
            const availabilityStatus = document.getElementById('availabilityStatus');
            const payButton = document.getElementById('payButton');

            if (!rentalStart || !duration || !tableId) {
                availabilityStatus.style.display = 'none';
                payButton.disabled = true;
                return;
            }

            // Clear previous timer
            if (availabilityTimer) {
                clearTimeout(availabilityTimer);
            }

            // Show loading state
            availabilityStatus.innerHTML = `
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 flex items-center gap-3">
                    <div class="animate-spin">
                        <i class="ri-loader-4-line text-yellow-600 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-yellow-800 gtregular">Memeriksa ketersediaan meja...</p>
                </div>
            `;
            availabilityStatus.style.display = 'block';
            payButton.disabled = true;

            // Debounce the availability check
            availabilityTimer = setTimeout(() => {
                fetch('{{ route('billiard.calculate-price') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                duration_hours: parseInt(duration),
                                rental_start: rentalStart,
                                table_id: tableId
                            })
                        })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.available !== false) {
                            availabilityStatus.innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded-md p-4 flex items-center gap-3">
                                <i class="ri-checkbox-circle-fill text-green-600 text-xl"></i>
                                <p class="text-sm font-medium text-green-800 gtregular">Meja tersedia untuk waktu yang dipilih</p>
                            </div>
                        `;
                            payButton.disabled = false;
                        } else {
                            availabilityStatus.innerHTML = `
                            <div class="bg-red-50 border border-red-200 rounded-md p-4 flex items-center gap-3">
                                <i class="ri-close-circle-fill text-red-600 text-xl"></i>
                                <p class="text-sm font-medium text-red-800 gtregular">${data.message || 'Meja tidak tersedia untuk waktu yang dipilih'}</p>
                            </div>
                        `;
                            payButton.disabled = true;
                        }
                        availabilityStatus.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error checking availability:', error);
                        availabilityStatus.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-md p-4 flex items-center gap-3">
                            <i class="ri-error-warning-fill text-red-600 text-xl"></i>
                            <p class="text-sm font-medium text-red-800 gtregular">Terjadi kesalahan saat memeriksa ketersediaan</p>
                        </div>
                    `;
                        payButton.disabled = true;
                    });
            }, 500); // 500ms delay
        }

        // Auto-calculate if duration is already selected (for form errors)
        document.addEventListener('DOMContentLoaded', function() {
            const durationSelect = document.getElementById('duration_hours');
            const rentalStart = document.getElementById('rental_start');
            const tableSelect = document.getElementById('table_select');

            // Initialize selected table ID
            updateSelectedTable();

            // Check if all fields are filled and trigger calculation
            setTimeout(() => {
                if (durationSelect.value && rentalStart.value && tableSelect.value) {
                    calculatePrice();
                } else if (durationSelect.value && tableSelect.value) {
                    calculatePrice();
                }
            }, 100);
        });
    </script>
</body>

</html>