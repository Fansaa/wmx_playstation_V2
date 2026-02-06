@extends('layouts.app')

@section('title', 'Beli Paket - WMX PLAY & WIN')

@push('styles')
<style>
    body { padding-bottom: 5rem; }
</style>
@endpush

@section('content')
<main class="py-8">
    <div class="container">
        <!-- Header -->
        <div class="card mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <span>🛒</span> Beli Paket Gaming WMX
            </h2>
        </div>

        @if($pendingPayment)
        <!-- Pending Payment Status -->
        <div class="card mb-6" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span>⏳</span> Menunggu Verifikasi
            </h3>
            <p class="text-gray-700 mb-4">Pembayaran Anda sedang diverifikasi oleh admin. Proses verifikasi membutuhkan waktu 1x24 jam.</p>
            <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                <div class="grid grid-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Atas Nama</p>
                        <p class="font-semibold">{{ $pendingPayment->account_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Transaksi</p>
                        <p class="font-semibold">{{ $pendingPayment->transaction_number }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Package Cards -->
        @foreach($packages as $package)
        <div class="card mb-6" style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe);">
            <div class="text-center mb-6">
                <div style="width: 6rem; height: 6rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1.5rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 2.5rem; color: white;">🎮</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $package->name }}</h3>
                <div style="background: white; border-radius: 1rem; padding: 1rem; display: inline-block;">
                    <p class="text-3xl font-bold text-sky-600">{{ $package->formatted_price }}</p>
                </div>
            </div>

            <!-- Benefits -->
            <div class="grid grid-3 gap-4 mb-6">
                <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-center;">
                    <div style="width: 3rem; height: 3rem; background: #dbeafe; border-radius: 1rem; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #2563eb;">⏰</span>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-1">{{ $package->regular_hours }} Jam Reguler</h5>
                    <p class="text-sm text-gray-600">Main PS dengan waktu fleksibel</p>
                </div>
                <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-center;">
                    <div style="width: 3rem; height: 3rem; background: #f3e8ff; border-radius: 1rem; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #7c3aed;">👑</span>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-1">{{ $package->vip_hours }} Jam VIP</h5>
                    <p class="text-sm text-gray-600">Akses prioritas & fasilitas premium</p>
                </div>
                <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-center;">
                    <div style="width: 3rem; height: 3rem; background: #ffedd5; border-radius: 1rem; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #ea580c;">🎫</span>
                    </div>
                    <h5 class="font-bold text-gray-800 mb-1">{{ $package->coupon_count }} Kode Kupon</h5>
                    <p class="text-sm text-gray-600">Kesempatan menang hadiah utama</p>
                </div>
            </div>

            <!-- Prizes -->
            <div style="background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 1rem; padding: 1.5rem; color: white; text-align: center; margin-bottom: 1.5rem;">
                <h5 class="text-lg font-bold mb-4">🏆 Hadiah Undian Spektakuler!</h5>
                <div class="flex justify-center gap-6" style="flex-wrap: wrap;">
                    <span class="flex items-center gap-2"><span style="font-size: 1.5rem;">🏍️</span> Motor ZX-25RR</span>
                    <span class="flex items-center gap-2"><span style="font-size: 1.5rem;">📱</span> iPhone 17 Pro Max</span>
                    <span class="flex items-center gap-2"><span style="font-size: 1.5rem;">🎮</span> PlayStation 5</span>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('dashboard.packages.payment', $package) }}" class="btn btn-primary" style="font-size: 1.125rem;">
                    🛒 BELI PAKET SEKARANG
                </a>
            </div>
        </div>
        @endforeach

        @if($packages->isEmpty())
        <div class="card text-center" style="padding: 3rem;">
            <p class="text-4xl mb-4">📦</p>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Paket Tersedia</h3>
            <p class="text-gray-600">Paket akan segera tersedia. Cek kembali nanti.</p>
        </div>
        @endif
        @endif
    </div>
</main>

<!-- Bottom Navigation -->
<nav class="dashboard-nav">
    <div class="dashboard-nav-items">
        <a href="{{ route('dashboard.index') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">👤</span>
            <span class="dashboard-nav-label">Profil</span>
        </a>
        <a href="{{ route('dashboard.packages') }}" class="dashboard-nav-item active">
            <span class="dashboard-nav-icon">🛒</span>
            <span class="dashboard-nav-label">Beli Paket</span>
        </a>
        <a href="{{ route('dashboard.quota') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">🎮</span>
            <span class="dashboard-nav-label">Kuota PS</span>
        </a>
        <a href="{{ route('dashboard.coupons') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">🎫</span>
            <span class="dashboard-nav-label">Kupon</span>
        </a>
    </div>
</nav>
@endsection
