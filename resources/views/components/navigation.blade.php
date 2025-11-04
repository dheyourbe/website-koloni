<nav x-data="{ open: false }" class="navbar sticky top-0 z-[9999] bg-white text-[#333333] text-lg border-b border-[#E5E5E5] max-w-7xl mx-auto garden flex items-center font-medium justify-between px-6 md:px-10">
    <!-- Left Navigation Links -->
    <ul class="hidden md:flex space-x-10">
        <li>
            <a href="{{ route('home') }}" class="hover:text-[#701D0D] transition-all {{ request()->routeIs('home') ? 'text-[#701D0D]' : '' }}">
                Home
            </a>
        </li>
        <li>
            <a href="{{ url('/#products') }}" class="hover:text-[#701D0D] transition-all">Products</a>
        </li>
        <li>
            <a href="{{ route('billiard.index') }}" class="hover:text-[#701D0D] transition-all {{ request()->routeIs('billiard.*') ? 'text-[#701D0D]' : '' }}">
                Billiard
            </a>
        </li>
    </ul>

    <!-- Logo -->
    <div class="logo h-20 w-30">

        <a href="{{ route('home') }}" class="hover:text-[#701D0D] transition-all {{ request()->routeIs('home') ? 'text-[#701D0D]' : '' }}">
            <img src="{{ asset('assets/images/Mask group.png') }}" alt="Logoshop" />
        </a>

    </div>

    <!-- Right Navigation Links -->
    <ul class="hidden md:flex space-x-10">
        <li>
            <a href="{{ url('/#contact') }}" class="hover:text-[#701D0D] transition-all">Contact</a>
        </li>
        <li class="flex items-center gap-2">
            @auth
            <!-- Settings Dropdown for Authenticated Users -->
            <div class="relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="text-base flex items-center gap-2 hover:text-[#701D0D] transition-all">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                    <div class="py-1">
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <!-- Join Member for Guests -->
            <a href="{{ route('login') }}"
                class="text-base flex items-center gap-2 hover:text-[#701D0D] transition-all">
                Join Member
                <i class="ri-arrow-right-up-line text-lg"></i>
            </a>
            @endauth
        </li>
    </ul>

    <!-- Mobile Menu Button -->
    <button @click="open = ! open" class="md:hidden text-2xl">
        <i class="ri-bar-chart-horizontal-line"></i>
    </button>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="backdrop-blur-md bg-white border-t border-[#E5E5E5] w-full shadow-md gap-4 rounded-b-3xl p-5 absolute top-0 left-0 md:hidden"
        style="display: none;">
        <div class="bg-transparent h-screen top-120 w-full absolute z-[9999] mx-auto left-0" @click="open = false"></div>
        <div class="flex items-start justify-between px-2 pt-10">
            <div class="flex flex-col gap-4">
                <a href="{{ route('home') }}" class="text-lg hover:text-[#701D0D] {{ request()->routeIs('home') ? 'text-[#701D0D]' : '' }}">Home</a>
                <a href="{{ url('/#products') }}" class="hover:text-[#701D0D] transition-all">Products</a>
                <a href="{{ route('billiard.index') }}" class="text-lg hover:text-[#701D0D] {{ request()->routeIs('billiard.*') ? 'text-[#701D0D]' : '' }}">Billiard</a>
                <a href="{{ url('/#contact') }}" class="hover:text-[#701D0D] transition-all">Contact</a>

                @auth
                <!-- Mobile User Menu -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="px-4 mb-3">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-lg text-gray-700 hover:text-[#701D0D]">
                            Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-lg text-gray-700 hover:text-[#701D0D]">
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-lg text-gray-700 hover:text-[#701D0D]">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Mobile Guest Menu -->
                <a href="{{ route('login') }}" class="text-lg flex items-center gap-2 hover:text-[#701D0D]">
                    Join Member
                    <i class="ri-arrow-right-up-line text-lg"></i>
                </a>
                @endauth
            </div>
            <div class="text-[#701D0D] items-center flex justify-center rounded-full cursor-pointer" @click="open = false">
                <i class="ri-close-line text-2xl"></i>
            </div>
        </div>
    </div>
</nav>

<!-- Include Alpine.js for dropdown functionality -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>