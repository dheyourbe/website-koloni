<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billiard Tables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Available Billiard Tables</h3>
                                <p class="text-sm text-gray-600">
                                    Choose a table to start your billiard rental. 
                                    @auth
                                        <span class="text-green-600 font-medium">As a member, you get 10% discount!</span>
                                    @else
                                        <span class="text-blue-600">Login to get 10% member discount!</span>
                                    @endauth
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('billiard.book') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
                                    🎱 Book Any Table
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($tables->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($tables as $table)
                                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    {{-- Images commented out --}}
                                    {{-- @if($table->photo)
                                        <img src="{{ Storage::url($table->photo) }}" alt="{{ $table->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif --}}
                                    
                                    <div class="p-4">
                                        <h4 class="font-semibold text-lg text-gray-900 mb-1">
                                            {{ $table->name ?: $table->table_number }}
                                        </h4>
                                        <p class="text-sm text-gray-600 mb-1">{{ $table->table_number }}</p>
                                        
                                        @if($table->description)
                                            <p class="text-sm text-gray-500 mb-3">{{ $table->description }}</p>
                                        @endif

                                        @if($table->isOccupied())
                                            <div class="bg-red-100 text-red-800 px-3 py-2 rounded-md text-sm font-medium mb-3">
                                                Currently Occupied
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium">Rp 120,000</span> / hour
                                                @auth
                                                    <br><span class="text-green-600 text-xs">Member: Rp 108,000 / hour</span>
                                                @endauth
                                            </div>
                                            
                                            <a href="{{ route('billiard.book', $table) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $table->isOccupied() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                               @if($table->isOccupied()) onclick="return false;" @endif>
                                                {{ $table->isOccupied() ? 'Occupied' : 'Book This Table' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No billiard tables available</h3>
                            <p class="mt-1 text-sm text-gray-500">Tables will appear here once they are added by the admin.</p>
                        </div>
                    @endif

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                @auth
                                    <a href="{{ route('billiard.history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View My Rental History
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Login to view rental history
                                    </a>
                                @endauth
                            </div>
                            <div class="text-sm text-gray-500">
                                Operating Hours: 10:00 AM - 10:00 PM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
