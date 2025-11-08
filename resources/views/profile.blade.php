<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://steadfast-light-caffe.up.railway.app/build/assets/app-oxxngOD7.css" />
    <title>Profil Saya - {{ config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main class="main max-w-7xl mx-auto py-8 px-4">
        <!-- Profile Header -->
        <div class="bg-white border border-gray-200 p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-20 h-20 bg-[#1B2B28] rounded-full flex items-center justify-center text-white text-2xl font-bold gtbold mr-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold gtbold text-[#1B2B28]">Profil Saya</h1>
                    <p class="text-gray-600">Kelola informasi akun dan lihat histori pemesanan Anda</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-xl font-semibold gtbold text-[#1B2B28] mb-4">Informasi Pribadi</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="ri-user-line text-[#1B2B28] mr-3 text-xl"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                <p class="text-gray-800 gtmedium">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="ri-mail-line text-[#1B2B28] mr-3 text-xl"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-800 gtmedium">{{ $user->email }}</p>
                            </div>
                        </div>
                        @if($user->no_wa)
                        <div class="flex items-center">
                            <i class="ri-whatsapp-line text-[#1B2B28] mr-3 text-xl"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nomor WhatsApp</label>
                                <p class="text-gray-800 gtmedium">{{ $user->no_wa }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="flex items-center">
                            <i class="ri-calendar-line text-[#1B2B28] mr-3 text-xl"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Bergabung Sejak</label>
                                <p class="text-gray-800 gtmedium">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold gtbold text-[#1B2B28] mb-4">Keuntungan Member</h2>
                    <div class="space-y-4">
                        <div class="bg-[#1B2B28] text-white p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="gtregular">Poin Saat Ini</span>
                                <span class="text-2xl font-bold gtbold">{{ $user->points ?? 0 }}</span>
                            </div>
                            <div class="w-full bg-gray-300 rounded-full h-2">
                                <div class="bg-[#EAE3D6] h-2 rounded-full" style="width: {{ min(($user->points ?? 0) / 10, 100) }}%"></div>
                            </div>
                        </div>

                        <div class="border border-gray-200 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <span class="gtmedium text-gray-700">Diskon Member</span>
                                <span class="text-xl font-bold gtbold text-[#1B2B28]">10%</span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center text-sm">
                                    <i class="ri-checkbox-circle-fill text-green-500 mr-2"></i>
                                    <span class="gtregular">Diskon 10% untuk semua pemesanan billiard</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="ri-checkbox-circle-fill text-green-500 mr-2"></i>
                                    <span class="gtregular">Dapatkan poin dengan setiap transaksi</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="ri-checkbox-circle-fill text-green-500 mr-2"></i>
                                    <span class="gtregular">Prioritas pemesanan di jam sibuk</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="ri-checkbox-circle-fill text-green-500 mr-2"></i>
                                    <span class="gtregular">Penawaran eksklusif untuk member</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('profile.edit') }}" class="bg-[#1B2B28] text-white px-6 py-3 rounded-full gtmedium hover:bg-[#701D0D] transition-all flex items-center gap-2">
                    <i class="ri-edit-line"></i>
                    Edit Profil
                </a>
                <a href="{{ route('billiard.index') }}" class="border-2 border-[#1B2B28] text-[#1B2B28] px-6 py-3 rounded-full gtmedium hover:bg-[#1B2B28] hover:text-white transition-all flex items-center gap-2">
                    <i class="ri-add-line"></i>
                    Pesan Meja
                </a>
            </div>
        </div>

        <!-- Booking History -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold gtbold text-[#1B2B28]">Riwayat Pemesanan</h2>

                @auth
                <a href="{{ route('billiard.history') }}"
                    class="text-[#1B2B28] hover:text-[#701D0D] text-sm font-medium flex items-center gap-2 gtmedium">
                    <i class="ri-history-line"></i>
                    <span>[{{ $rentals->count() }}]</span>
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

            @if($rentals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rentals as $rental)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-[#1B2B28] rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                        {{ strtoupper(substr($rental->transaction_number, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 gtmedium">{{ $rental->transaction_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="ri-table-line text-[#1B2B28] mr-2"></i>
                                    <span class="text-sm text-gray-900 gtmedium">Meja {{ $rental->billiardTable->table_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 gtregular">
                                {{ $rental->rental_start ? $rental->rental_start->format('d F Y, H:i') : 'Belum ditentukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 gtregular">
                                <div class="flex items-center">
                                    <i class="ri-time-line text-[#1B2B28] mr-1"></i>
                                    {{ $rental->duration_hours }} jam
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-[#1B2B28] gtbold">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($rental->discount_amount > 0)
                                <span class="text-green-600 gtmedium">-Rp {{ number_format($rental->discount_amount, 0, ',', '.') }}</span>
                                @else
                                <span class="text-gray-400 gtregular">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full gtmedium
                                        @if($rental->status === 'paid') bg-green-100 text-green-800
                                        @elseif($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                    @if($rental->status === 'paid')
                                    <i class="ri-checkbox-circle-fill mr-1"></i> Lunas
                                    @elseif($rental->status === 'pending')
                                    <i class="ri-time-fill mr-1"></i> Menunggu
                                    @else
                                    <i class="ri-close-circle-fill mr-1"></i> Batal
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $rentals->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="ri-calendar-2-line text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 gtbold">Belum Ada Pemesanan</h3>
                <p class="text-gray-500 mb-6 gtregular">Anda belum pernah melakukan pemesanan meja billiard</p>
                <a href="{{ route('billiard.index') }}" class="bg-[#1B2B28] text-white px-6 py-3 rounded-full gtmedium hover:bg-[#701D0D] transition-all flex items-center gap-2 mx-auto w-fit">
                    <i class="ri-add-line"></i>
                    Buat Pemesanan Pertama Anda
                </a>
            </div>
            @endif
        </div>
    </main>
</body>

</html>