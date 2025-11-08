<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KOLONI Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8">
        <div class="text-center">
            <img src="{{ asset('assets/images/Mask group.png') }}" alt="KOLONI Coffee" class="mx-auto h-16 w-auto mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-sm text-gray-600">
                Atau
                <a href="{{ route('register') }}" class="font-medium text-[#1B2B28] hover:text-[#701D0D]">
                    daftar sebagai member baru
                </a>
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <input type="hidden" name="remember" value="true">

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email atau Username
                    </label>
                    <div class="mt-1">
                        <input
                            id="email"
                            name="email"
                            type="text"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#1B2B28] focus:border-[#1B2B28] sm:text-sm"
                            placeholder="Masukkan email atau username"
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#1B2B28] focus:border-[#1B2B28] sm:text-sm"
                            placeholder="Masukkan password"
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-[#1B2B28] focus:ring-[#1B2B28] border-gray-300 rounded"
                        >
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-[#1B2B28] hover:text-[#701D0D]">
                            Lupa password?
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#1B2B28] hover:bg-[#701D0D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B2B28] transition-colors"
                >
                    Masuk
                </button>
            </div>


        </form>
    </div>
</body>
</html>
