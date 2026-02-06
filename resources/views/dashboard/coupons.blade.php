@extends('layouts.app')

@section('title', 'Kupon Saya - WMX PLAY & WIN')

@push('styles')
<style>
    body { padding-bottom: 5rem; }
</style>
@endpush

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card">
            <div class="flex justify-between items-center mb-6" style="flex-wrap: wrap; gap: 1rem;">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <span>🎫</span> Kupon Saya
                </h2>
                <form method="GET" class="flex gap-2">
                    <select name="status" class="form-select" style="width: auto;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Digunakan</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </form>
            </div>

            @if($coupons->isEmpty())
            <div class="text-center" style="padding: 3rem;">
                <p class="text-4xl mb-4">🎟️</p>
                <h4 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Kupon Tersedia</h4>
                <p class="text-gray-600 mb-4">Kupon akan muncul setelah pembelian paket diverifikasi admin</p>
                <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 1rem; padding: 1rem; max-width: 24rem; margin: 0 auto; text-align: left;">
                    <p class="text-sm text-blue-800 font-semibold mb-2">💡 Cara Mendapat Kupon:</p>
                    <ul class="text-sm text-blue-700" style="padding-left: 1rem;">
                        <li>• Beli paket gaming Rp 200.000</li>
                        <li>• Tunggu verifikasi admin</li>
                        <li>• Kupon otomatis muncul di sini</li>
                        <li>• Ajak teman untuk bonus kupon</li>
                    </ul>
                </div>
            </div>
            @else
            <div class="grid gap-4">
                @foreach($coupons as $coupon)
                <div style="background: linear-gradient(135deg, {{ $coupon->status == 'active' ? '#dcfce7, #bbf7d0' : ($coupon->status == 'used' ? '#dbeafe, #bfdbfe' : '#f3f4f6, #e5e7eb') }}); border-radius: 1rem; padding: 1.5rem;">
                    <div class="flex justify-between items-start" style="flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <p class="text-sm text-gray-500">Kode Kupon</p>
                            <p class="text-xl font-bold" style="font-family: monospace; {{ $coupon->status == 'active' ? 'color: #16a34a;' : 'color: #6b7280;' }}">{{ $coupon->code }}</p>
                        </div>
                        <span class="badge badge-{{ $coupon->status_color }}">{{ ucfirst($coupon->status) }}</span>
                    </div>
                    <div class="mt-4 grid grid-2 gap-4" style="font-size: 0.875rem;">
                        <div>
                            <p class="text-gray-500">Dari Paket</p>
                            <p class="font-semibold">{{ $coupon->payment->package->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Berlaku Hingga</p>
                            <p class="font-semibold">{{ $coupon->expires_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @if($coupon->status == 'active')
                    <button onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); alert('Kode kupon tersalin!')" class="btn btn-primary mt-4" style="width: 100%;">
                        📋 Salin Kode Kupon
                    </button>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Bottom Navigation -->
<nav class="dashboard-nav">
    <div class="dashboard-nav-items">
        <a href="{{ route('dashboard.index') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">👤</span>
            <span class="dashboard-nav-label">Profil</span>
        </a>
        <a href="{{ route('dashboard.packages') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">🛒</span>
            <span class="dashboard-nav-label">Beli Paket</span>
        </a>
        <a href="{{ route('dashboard.quota') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">🎮</span>
            <span class="dashboard-nav-label">Kuota PS</span>
        </a>
        <a href="{{ route('dashboard.coupons') }}" class="dashboard-nav-item active">
            <span class="dashboard-nav-icon">🎫</span>
            <span class="dashboard-nav-label">Kupon</span>
        </a>
    </div>
</nav>
@endsection
