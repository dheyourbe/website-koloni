<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Billiard Table') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Pricing Information -->
                    <div class="mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-4 text-lg">🎱 Billiard Table Rental</h4>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-blue-800">
                                        <span class="font-medium">Regular Rate:</span> Rp 120,000 per hour
                                    </p>
                                </div>
                                <div>
                                    @auth
                                        <p class="text-sm text-green-800">
                                            <span class="font-medium">🎁 Member Rate:</span> Rp 108,000 per hour (10% off)
                                        </p>
                                    @else
                                        <p class="text-sm text-orange-700">
                                            💡 <a href="{{ route('login') }}" class="underline font-medium">Login</a> or <a href="{{ route('register') }}" class="underline font-medium">Register</a> to get 10% member discount!
                                        </p>
                                    @endauth
                                </div>
                            </div>
                            
                            @guest
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3 mb-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-800">
                                            <strong>💰 Save Money!</strong> Create a free account to get 10% off all billiard rentals. 
                                            <a href="{{ route('register') }}" class="underline font-medium">Register now</a> and start saving!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endguest
                            <p class="text-sm text-blue-700">📅 Available: 9:00 AM - 10:00 PM daily</p>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form action="{{ route('billiard.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="billiard_table_id" value="" id="selectedTableId">
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Table Selection -->
                            <div>
                                <label for="table_select" class="block text-sm font-medium text-gray-700">
                                    Select Billiard Table
                                </label>
                                <select id="table_select" name="table_select" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        onchange="updateSelectedTable()">
                                    <option value="">Choose a table...</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}" 
                                                data-name="{{ $table->name ?: $table->table_number }}"
                                                data-number="{{ $table->table_number }}"
                                                {{ $selectedTable && $selectedTable->id == $table->id ? 'selected' : '' }}>
                                            {{ $table->table_number }} {{ $table->name ? '- ' . $table->name : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Select which table you want to book</p>
                                @error('billiard_table_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                <input type="text" id="customer_name" name="customer_name" 
                                       value="{{ old('customer_name', $user?->name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label for="customer_whatsapp" class="block text-sm font-medium text-gray-700">
                                    WhatsApp Number <span class="text-gray-500">(optional, for receipt)</span>
                                </label>
                                <input type="text" id="customer_whatsapp" name="customer_whatsapp" 
                                       value="{{ old('customer_whatsapp', $user?->no_wa) }}"
                                       placeholder="e.g., 08123456789"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Receipt will be sent to this WhatsApp number</p>
                                @error('customer_whatsapp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rental Start Time -->
                            <div>
                                <label for="rental_start" class="block text-sm font-medium text-gray-700">
                                    Rental Start Time
                                </label>
                                <input type="datetime-local" id="rental_start" name="rental_start" 
                                       value="{{ old('rental_start', now()->addHour()->format('Y-m-d\TH:i')) }}" required
                                       min="{{ now()->format('Y-m-d\TH:i') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                       onchange="checkAvailability()">
                                <p class="mt-1 text-xs text-gray-500">Select when you want to start your rental</p>
                                @error('rental_start')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration_hours" class="block text-sm font-medium text-gray-700">
                                    Rental Duration (Hours)
                                </label>
                                <select id="duration_hours" name="duration_hours" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        onchange="calculatePrice(); checkAvailability();">
                                    <option value="">Select duration...</option>
                                    @for($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}" {{ old('duration_hours') == $i ? 'selected' : '' }}>
                                            {{ $i }} hour{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('duration_hours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Availability Status -->
                            <div id="availabilityStatus" style="display: none;"></div>
                        </div>

                        <!-- Price Calculation -->
                        <div class="mt-8 bg-gray-50 p-6 rounded-lg" id="priceCalculation" style="display: none;">
                            <h4 class="font-medium text-gray-900 mb-4">Price Calculation</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Price per hour:</span>
                                    <span id="pricePerHour">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">-</span>
                                </div>
                                <div class="flex justify-between" id="discountRow" style="display: none;">
                                    <span class="text-green-600">Member Discount (10%):</span>
                                    <span class="text-green-600" id="discount">-</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex justify-between font-medium text-lg">
                                    <span>Total Amount:</span>
                                    <span id="totalAmount" class="text-blue-600">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                        <div class="mt-2 text-sm text-red-700">
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
                        <div class="mt-8 flex items-center justify-end space-x-4">
                            <a href="{{ route('billiard.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" id="payButton"
                                    class="bg-blue-600 py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                🎱 Pay & Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                body: JSON.stringify({ duration_hours: duration })
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
            const availabilityStatus = document.getElementById('availabilityStatus');
            const payButton = document.getElementById('payButton');

            if (!rentalStart || !duration) {
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
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                    <div class="flex">
                        <svg class="animate-spin h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-yellow-800">Checking availability...</p>
                    </div>
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
                        table_id: document.getElementById('selectedTableId').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.available !== false) {
                        availabilityStatus.innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded-md p-3">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="ml-3 text-sm font-medium text-green-800">Table is available for the selected time</p>
                                </div>
                            </div>
                        `;
                        payButton.disabled = false;
                    } else {
                        availabilityStatus.innerHTML = `
                            <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="ml-3 text-sm font-medium text-red-800">${data.message || 'Table is not available for the selected time'}</p>
                                </div>
                            </div>
                        `;
                        payButton.disabled = true;
                    }
                    availabilityStatus.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                    availabilityStatus.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-md p-3">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-sm font-medium text-red-800">Error checking availability</p>
                            </div>
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
            
            if (durationSelect.value && rentalStart.value && tableSelect.value) {
                calculatePrice();
            } else if (durationSelect.value && tableSelect.value) {
                calculatePrice();
            } else if (rentalStart.value && tableSelect.value) {
                checkAvailability();
            }
        });
    </script>
</x-app-layout>
