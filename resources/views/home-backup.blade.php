<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Coffee & Billiard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-800">Coffee & Billiard</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-600">Hello, {{ auth()->user()->name }}!</span>
                        <a href="{{ route('user.profile') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                            Join Member
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome to Coffee & Billiard</h1>
            <p class="text-xl mb-8">Enjoy premium coffee and professional billiard tables in a relaxing atmosphere</p>
            <a href="#billiard-tables" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Book a Table Now
            </a>
        </div>
    </section>

    <!-- Billiard Booking Section -->
    <section id="billiard-booking" class="py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Billiard Table Booking</h2>
            
            <!-- Single Booking Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-2xl">
                <div class="bg-gradient-to-r from-green-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-center mb-2">🎱 Professional Billiard Tables</h3>
                    <p class="text-center text-green-100">High-quality billiard tables available for rental</p>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $tableCount }}</div>
                            <div class="text-gray-600 text-sm">Available Tables</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">Rp 120K</div>
                            <div class="text-gray-600 text-sm">Per Hour</div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    @auth
                                        <strong>🎁 Member Discount:</strong> Get 10% off as a registered member! (Rp 108,000/hour)
                                    @else
                                        <strong>💡 Member Benefit:</strong> Register to get 10% discount on all bookings!
                                    @endauth
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('billiard.index') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            🎱 Book a Table Now
                        </a>
                        <p class="text-gray-500 text-sm mt-3">Available from 9 AM to 10 PM daily</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
    <!-- Recent Bookings Section (Only for authenticated users) -->
    @if($userRentals && $userRentals->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Your Recent Bookings</h2>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($userRentals as $rental)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $rental->transaction_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $rental->billiardTable->table_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $rental->rental_start ? $rental->rental_start->format('M d, Y H:i') : 'Not set' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $rental->duration_hours }} hours
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($rental->status === 'paid') bg-green-100 text-green-800
                                        @elseif($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="text-center mt-6">
                <a href="{{ route('user.profile') }}" class="text-blue-600 hover:text-blue-800">
                    View all bookings →
                </a>
            </div>
        </div>
    </section>
    @endif
    @endauth

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 Coffee & Billiard. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
