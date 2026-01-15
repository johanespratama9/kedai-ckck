<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan - Meja {{ $nomorMeja }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': {
                            50: '#f0f9ff',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showNotification('{{ session('success') }}', 'success');
        
        // Auto scroll ke keranjang
        setTimeout(() => {
            const cartSection = document.getElementById('cartSection');
            if (cartSection) {
                cartSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 500);
    });
</script>
@endif

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-slate-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-brand-100 p-3 rounded-xl">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo CKCK" class="h-12 w-12 rounded-lg">
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Kedai CKCK</h1>
                    <p class="text-slate-600">Premium Coffee & Kitchen</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-brand-600 text-white px-6 py-3 rounded-xl">
                    <p class="text-sm font-medium">Meja</p>
                    <p class="text-2xl font-bold">{{ $nomorMeja }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
            <p class="text-slate-600">ID Pesanan: <span class="font-semibold text-brand-700">#{{ $order->id }}</span></p>
            
            <!-- Button Cek Histori -->
            <a href="{{ route('order.historyForm') }}" 
               class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Cek Riwayat Pesanan
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <form method="POST" action="{{ route('order.addItem', $order->id) }}" class="space-y-8">
        @csrf
        
        <!-- Customer Info Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pelanggan</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                    <input type="tel" 
                           id="phoneInput"
                           name="phone" 
                           value="{{ old('phone', $order->phone) }}" 
                           required
                           placeholder="Contoh: 081234567890"
                           pattern="[0-9]+"
                           inputmode="numeric"
                           maxlength="15"
                           class="w-full px-4 py-3 border @error('phone') border-red-500 @else border-slate-300 @enderror rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                    <div id="phoneError" class="hidden flex items-center mt-2 text-red-500 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span>Hanya angka (0-9) yang diizinkan</span>
                    </div>
                    <div id="phoneSuccess" class="hidden flex items-center mt-2 text-green-600 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Nomor HP valid</span>
                    </div>
                    @if (!$errors->has('phone'))
                        <p class="text-slate-500 text-xs mt-1">Hanya angka (0-9), minimal 10 angka</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $order->keterangan) }}"
                           placeholder="Contoh: tanpa pedas, extra saus"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors">
                </div>
            </div>
        </div>

        <!-- Menu Selection Card with Tabs -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Pilih Menu</h2>
            
            <!-- Tab Navigation -->
            <div class="flex flex-wrap gap-2 mb-6 border-b border-slate-200 pb-3">
                <button class="menu-tab-btn active px-6 py-2 font-semibold text-brand-600 border-b-2 border-brand-600 transition-colors" data-category="makanan">
                    🍔 Makanan
                </button>
                <button class="menu-tab-btn px-6 py-2 font-semibold text-slate-600 border-b-2 border-transparent hover:text-slate-900 transition-colors" data-category="minuman">
                    🥤 Minuman
                </button>
            </div>

            <!-- Makanan Tab -->
            <div id="makanan-tab" class="menu-tab-content">
                @php
                    $makananList = $menus->where('kategori', 'makanan');
                @endphp
                @if($makananList->count() > 0)
                    <p class="text-slate-600 text-sm mb-4">Pilih menu makanan favorit Anda</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($makananList as $menu)
                            <div class="group bg-slate-50 rounded-2xl p-3 border border-slate-200 hover:border-brand-300 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="aspect-square mb-3 overflow-hidden rounded-xl bg-white shadow-sm cursor-pointer"
                                     onclick="openMenuModal({{ $menu->id }}, '{{ $menu->nama }}', '{{ addslashes($menu->keterangan ?? '') }}', '{{ $menu->foto ? ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama) }}', {{ $menu->harga }})">
                                    @if($menu->foto)
                                        <img src="{{ ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) }}" alt="{{ $menu->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 group-hover:scale-105 transition-transform duration-300">
                                            <div class="text-center p-4">
                                                <svg class="w-16 h-16 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-xs text-slate-500">No Image</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center space-y-2">
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $menu->nama }}</h3>
                                    <p class="text-brand-600 font-bold text-sm">Rp {{ number_format($menu->harga) }}</p>
                                    
                                    <button type="button" 
                                            onclick="openMenuModal({{ $menu->id }}, '{{ $menu->nama }}', '{{ addslashes($menu->keterangan ?? '') }}', '{{ ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) }}', {{ $menu->harga }})"
                                            class="w-full bg-brand-600 hover:bg-brand-700 text-white py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-8">Tidak ada menu makanan tersedia</p>
                @endif
            </div>

            <!-- Minuman Tab -->
            <div id="minuman-tab" class="menu-tab-content hidden">
                @php
                    $minumanList = $menus->where('kategori', 'minuman');
                @endphp
                @if($minumanList->count() > 0)
                    <p class="text-slate-600 text-sm mb-4">Pilih menu minuman favorit Anda</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($minumanList as $menu)
                            <div class="group bg-slate-50 rounded-2xl p-3 border border-slate-200 hover:border-brand-300 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="aspect-square mb-3 overflow-hidden rounded-xl bg-white shadow-sm cursor-pointer"
                                     onclick="openMenuModal({{ $menu->id }}, '{{ $menu->nama }}', '{{ addslashes($menu->keterangan ?? '') }}', '{{ $menu->foto ? ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama) }}', {{ $menu->harga }})">
                                    @if($menu->foto)
                                        <img src="{{ ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) }}" alt="{{ $menu->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 group-hover:scale-105 transition-transform duration-300">
                                            <div class="text-center p-4">
                                                <svg class="w-16 h-16 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-xs text-slate-500">No Image</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center space-y-2">
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $menu->nama }}</h3>
                                    <p class="text-brand-600 font-bold text-sm">Rp {{ number_format($menu->harga) }}</p>
                                    
                                    <button type="button" 
                                            onclick="openMenuModal({{ $menu->id }}, '{{ $menu->nama }}', '{{ addslashes($menu->keterangan ?? '') }}', '{{ ($menu->foto ? asset('storage/' . $menu->foto) : 'https://via.placeholder.com/400x400/e2e8f0/64748b?text=' . urlencode($menu->nama)) }}', {{ $menu->harga }})"
                                            class="w-full bg-brand-600 hover:bg-brand-700 text-white py-2 px-3 rounded-lg text-xs font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-8">Tidak ada menu minuman tersedia</p>
                @endif
            </div>
        </div>

        <script>
            // Validasi No. HP Real-time
            const phoneInput = document.getElementById('phoneInput');
            const phoneError = document.getElementById('phoneError');
            const phoneSuccess = document.getElementById('phoneSuccess');

            function validatePhone() {
                const submitButtons = document.querySelectorAll('button[type="submit"]');
                const value = phoneInput.value;
                
                if (value === '') {
                    // Jika kosong, sembunyikan error dan success
                    phoneError.classList.add('hidden');
                    phoneSuccess.classList.add('hidden');
                    submitButtons.forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                    return true;
                } else {
                    // Ada nilai dan hanya angka, enable button
                    phoneError.classList.add('hidden');
                    phoneSuccess.classList.remove('hidden');
                    phoneInput.classList.add('border-green-500');
                    phoneInput.classList.remove('border-red-500', 'border-slate-300');
                    
                    // Enable semua tombol submit
                    submitButtons.forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        btn.title = '';
                    });
                    return true;
                }
            }

            // Hapus karakter non-angka secara otomatis (real-time)
            phoneInput.addEventListener('input', function(e) {
                // Hapus semua karakter yang bukan angka
                let originalValue = this.value;
                this.value = this.value.replace(/[^\d]/g, '');
                
                // Jika ada karakter yang dihapus, tampilkan warning
                if (originalValue !== this.value && originalValue.length > this.value.length) {
                    showNotification('⚠️ Hanya angka yang diizinkan. Karakter lain dihapus otomatis.', 'warning');
                }
                
                validatePhone();
            });

            // Prevent dari mengetik karakter non-angka
            phoneInput.addEventListener('keypress', function(e) {
                // Hanya izinkan angka (0-9)
                if (!/[\d]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Prevent paste karakter non-angka
            phoneInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                const cleanedData = pasteData.replace(/[^\d]/g, '');
                
                if (cleanedData.length > 0) {
                    this.value = cleanedData;
                    validatePhone();
                }
                
                if (pasteData !== cleanedData) {
                    showNotification('✂️ Hanya angka yang di-paste. Karakter lain otomatis dihapus.', 'warning');
                }
            });

            // Prevent drag and drop file
            phoneInput.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            phoneInput.addEventListener('drop', function(e) {
                e.preventDefault();
            });

            // Validasi saat form di-load jika ada nilai sebelumnya
            if (phoneInput.value) {
                validatePhone();
            }

            // Tab switching functionality
            document.querySelectorAll('.menu-tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    
                    // Hide all tabs
                    document.querySelectorAll('.menu-tab-content').forEach(tab => {
                        tab.classList.add('hidden');
                    });
                    
                    // Deactivate all buttons
                    document.querySelectorAll('.menu-tab-btn').forEach(b => {
                        b.classList.remove('active', 'border-brand-600', 'text-brand-600');
                        b.classList.add('border-transparent', 'text-slate-600');
                    });
                    
                    // Show selected tab
                    document.getElementById(category + '-tab').classList.remove('hidden');
                    
                    // Activate selected button
                    this.classList.remove('border-transparent', 'text-slate-600');
                    this.classList.add('active', 'border-brand-600', 'text-brand-600');
                });
            });
        </script>
    </form>

    <!-- Cart Section -->
    <div id="cartSection" class="bg-white rounded-2xl shadow-xl p-6 border border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900">🛒 Keranjang Belanja</h2>
            @if ($order->orderItems->count() > 0)
                <span class="bg-brand-100 text-brand-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $order->orderItems->count() }} item
                </span>
            @endif
        </div>

        @if ($order->orderItems->count() > 0)
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full bg-white">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Foto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Menu</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Harga</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Jumlah</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Subtotal</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}"
                                         class="h-16 w-16 object-cover rounded-xl shadow-sm">
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $item->menu->nama }}</p>
                                    @if($item->note_selera)
                                        <p class="text-xs text-orange-600 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ $item->note_selera }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-slate-700">Rp {{ number_format($item->menu->harga) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-brand-100 text-brand-800 px-3 py-1 rounded-full font-semibold">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('order.removeItem', $item->id) }}"
                                          onsubmit="return confirm('Hapus item ini?')" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Total and Submit -->
            <div class="mt-6 space-y-4">
                <div class="bg-gradient-to-r from-brand-50 to-blue-50 rounded-xl p-6 border border-brand-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-slate-700">Total Harga:</span>
                        <span class="text-3xl font-bold text-brand-900">Rp {{ number_format($order->total_harga) }}</span>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('order.submit', $order->id) }}">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 px-6 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kirim Pesanan
                    </button>
                </form>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-600 mb-2">Keranjang masih kosong</h3>
                <p class="text-slate-500">Pilih menu di atas untuk menambahkan item ke keranjang</p>
            </div>
        @endif
    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" class="fixed bottom-4 right-4 space-y-3 z-50"></div>

<!-- Menu Detail Modal -->
<div id="menuModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeMenuModal()">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center rounded-t-3xl">
            <h3 id="modalTitle" class="text-2xl font-bold text-slate-900"></h3>
            <button onclick="closeMenuModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('order.addItem', $order->id) }}" id="modalForm">
            @csrf
            <input type="hidden" name="selected_menu" id="modalMenuId">
            <input type="hidden" name="customer_name" id="modalCustomerName">
            <input type="hidden" name="phone" id="modalPhone">
            <input type="hidden" name="keterangan" id="modalKeterangan">
            
            <div class="p-6 space-y-6">
                <!-- Menu Image -->
                <div class="w-full aspect-video overflow-hidden rounded-2xl bg-slate-100">
                    <img id="modalImage" src="" alt="" class="w-full h-full object-cover">
                </div>

                <!-- Menu Description -->
                <div class="bg-slate-50 rounded-2xl p-4">
                    <h4 class="font-semibold text-slate-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Deskripsi Menu
                    </h4>
                    <p id="modalDescription" class="text-slate-600"></p>
                </div>

                <!-- Price -->
                <div class="bg-gradient-to-r from-brand-50 to-blue-50 rounded-2xl p-4 border border-brand-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-slate-700">Harga:</span>
                        <span id="modalPrice" class="text-2xl font-bold text-brand-900"></span>
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Pesanan</label>
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="decrementQty()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 p-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <input type="number" name="quantity_modal" id="modalQuantity" value="1" min="1" max="99"
                               class="w-20 px-4 py-3 text-center text-xl font-bold border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                        <button type="button" onclick="incrementQty()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 p-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Customer Notes / Selera -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Catatan Selera (Opsional)
                    </label>
                    <div class="mb-3 flex flex-wrap gap-2">
                        <button type="button" onclick="setNote('Tidak Pedas')" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-xl text-sm font-medium transition-colors">
                            🌿 Tidak Pedas
                        </button>
                        <button type="button" onclick="setNote('Pedas Sedang')" class="px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-xl text-sm font-medium transition-colors">
                            🌶️ Pedas Sedang
                        </button>
                        <button type="button" onclick="setNote('Extra Pedas')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-sm font-medium transition-colors">
                            🔥 Extra Pedas
                        </button>
                        <button type="button" onclick="setNote('Tanpa Bawang')" class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-xl text-sm font-medium transition-colors">
                            🧅 Tanpa Bawang
                        </button>
                        <button type="button" onclick="setNote('Extra Saus')" class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl text-sm font-medium transition-colors">
                            🥫 Extra Saus
                        </button>
                    </div>
                    <textarea name="note_selera" id="modalNote" rows="3" 
                              placeholder="Contoh: tanpa sayur, extra sambal, matang betul, dll."
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 resize-none"></textarea>
                    <p class="text-slate-500 text-xs mt-1">Tulis permintaan khusus untuk pesanan Anda</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="sticky bottom-0 bg-white border-t border-slate-200 px-6 py-4 rounded-b-3xl">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 px-6 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal Functions
function openMenuModal(menuId, menuName, description, imageUrl, price) {
    // Validasi form customer terlebih dahulu
    const customerName = document.querySelector('input[name="customer_name"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    
    if (!customerName) {
        showNotification('⚠️ Mohon isi Nama Pelanggan terlebih dahulu', 'warning');
        document.querySelector('input[name="customer_name"]').focus();
        return;
    }
    
    if (!phone || phone.length < 10) {
        showNotification('⚠️ Mohon isi No. HP yang valid (minimal 10 angka)', 'warning');
        document.querySelector('input[name="phone"]').focus();
        return;
    }
    
    // Set data customer ke hidden input modal
    document.getElementById('modalCustomerName').value = customerName;
    document.getElementById('modalPhone').value = phone;
    document.getElementById('modalKeterangan').value = document.querySelector('input[name="keterangan"]').value || '';
    
    // Set data menu
    document.getElementById('menuModal').classList.remove('hidden');
    document.getElementById('menuModal').classList.add('flex');
    document.getElementById('modalTitle').textContent = menuName;
    document.getElementById('modalDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('modalMenuId').value = menuId;
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('modalNote').value = '';
    document.body.style.overflow = 'hidden'; // Prevent background scroll
}

function closeMenuModal() {
    document.getElementById('menuModal').classList.add('hidden');
    document.getElementById('menuModal').classList.remove('flex');
    document.body.style.overflow = 'auto'; // Restore scroll
}

function incrementQty() {
    const qtyInput = document.getElementById('modalQuantity');
    const currentValue = parseInt(qtyInput.value) || 1;
    if (currentValue < 99) {
        qtyInput.value = currentValue + 1;
    }
}

function decrementQty() {
    const qtyInput = document.getElementById('modalQuantity');
    const currentValue = parseInt(qtyInput.value) || 1;
    if (currentValue > 1) {
        qtyInput.value = currentValue - 1;
    }
}

function setNote(text) {
    const noteInput = document.getElementById('modalNote');
    const currentNote = noteInput.value.trim();
    
    if (currentNote === '') {
        noteInput.value = text;
    } else {
        noteInput.value = currentNote + ', ' + text;
    }
}

// Close modal dengan ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMenuModal();
    }
});

function showNotification(message, type = 'info') {
    const container = document.getElementById('notificationContainer');
    
    // Cek apakah notification dengan pesan yang sama sudah ada
    const existing = Array.from(container.children).find(el => el.textContent.includes(message.substring(0, 10)));
    if (existing) return; // Jangan duplicate
    
    const bgColor = {
        'success': 'bg-green-500',
        'warning': 'bg-yellow-500',
        'info': 'bg-blue-500',
        'error': 'bg-red-500'
    }[type] || 'bg-blue-500';
    
    const notification = document.createElement('div');
    notification.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-lg animate-fade-in`;
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove setelah 5 detik
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Polling untuk status order setiap 5 detik setelah order di-submit
let pollingInterval;
let lastApprovalStatus = null;
let hasNotifiedApproval = false;

function checkOrderStatus() {
    const orderId = {{ $order->id }};
    
    fetch(`/api/order/${orderId}/status`)
        .then(response => response.json())
        .then(data => {
            // Notifikasi saat order di-approve oleh admin (hanya sekali)
            if (data.approval_status === 'approved' && !hasNotifiedApproval) {
                const adminName = data.approved_by_name || 'Admin';
                const approvedTime = data.approved_at || '';
                showNotification(`✅ Pesanan diterima oleh ${adminName} pada ${approvedTime}`, 'success');
                hasNotifiedApproval = true;
                
                // Auto reload ke halaman invoice setelah 3 detik
                setTimeout(() => {
                    window.location.href = `/order/invoice/{{ $order->id }}`;
                }, 3000);
            }
            
            // Notifikasi rejection
            if (data.approval_status === 'rejected' && lastApprovalStatus !== 'rejected') {
                const adminName = data.approved_by_name || 'Admin';
                showNotification(`❌ Pesanan ditolak oleh ${adminName}. Silakan cek invoice untuk detail.`, 'error');
                lastApprovalStatus = 'rejected';
            }
            
            // Notifikasi status makanan
            if (data.status_makanan === 'pesanan sedang diproses') {
                // Tidak tampilkan notif terus menerus, cukup 1x
            } else if (data.status_makanan === 'pesanan selesai') {
                showNotification('✅ Pesanan Anda sudah siap! Silakan ambil di meja', 'success');
                // Hentikan polling jika sudah selesai
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
            }
            
            // Update last status
            lastApprovalStatus = data.approval_status;
        })
        .catch(error => console.error('Error:', error));
}

// Tambahkan CSS untuk animation
const style = document.createElement('style');
style.innerHTML = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);

// Mulai polling setelah 2 detik (tunggu halaman fully loaded)
setTimeout(() => {
    // Check status setiap 5 detik
    pollingInterval = setInterval(checkOrderStatus, 5000);
    // Juga check sekali saat page load
    checkOrderStatus();
}, 2000);
</script>

</body>
</html>
