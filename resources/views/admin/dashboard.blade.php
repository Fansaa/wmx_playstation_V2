@extends('layouts.app')

@section('title', 'Admin Dashboard - WMX PLAY & WIN')

@section('content')
<main class="py-8">
    <div class="container">
        <!-- Header -->
        <div class="card mb-6">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">🛡️ Admin Dashboard</h2>
                    <p class="text-gray-600">Kelola event WMX PLAY & WIN</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </div>

        <!-- Admin Navigation -->
        <div class="card mb-6">
            <div class="flex gap-2" style="flex-wrap: wrap;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">📊 Dashboard</a>
                <a href="{{ route('admin.users') }}" class="btn btn-outline">👥 Kelola User</a>
                <a href="{{ route('admin.payments') }}" class="btn btn-outline">💳 Verifikasi Pembayaran</a>
                <a href="{{ route('admin.coupons') }}" class="btn btn-outline">🎫 Kelola Kupon</a>
                <a href="{{ route('admin.draw') }}" class="btn btn-secondary">🎰 Undian</a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-2 gap-6 mb-6">
            <div class="card">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Statistik Event</h3>
                <div class="grid grid-2 gap-4">
                    <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 1rem; padding: 1rem; text-center;">
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_users']) }}</p>
                        <p class="text-sm text-gray-600">Total User</p>
                    </div>
                    <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 1rem; padding: 1rem; text-center;">
                        <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_packages']) }}</p>
                        <p class="text-sm text-gray-600">Total Paket Terjual</p>
                    </div>
                    <div style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); border-radius: 1rem; padding: 1rem; text-center;">
                        <p class="text-3xl font-bold" style="color: #7c3aed;">{{ number_format($stats['total_referrals']) }}</p>
                        <p class="text-sm text-gray-600">Total Referral</p>
                    </div>
                    <div style="background: linear-gradient(135deg, #ffedd5, #fed7aa); border-radius: 1rem; padding: 1rem; text-center;">
                        <p class="text-3xl font-bold text-orange-600">Rp {{ number_format($stats['total_revenue'] / 1000000, 1) }}jt</p>
                        <p class="text-sm text-gray-600">Total Pendapatan</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="text-lg font-bold text-gray-800 mb-4">⏳ Perlu Tindakan</h3>
                <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1rem;">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800">Pembayaran Pending</p>
                            <p class="text-sm text-gray-600">Menunggu verifikasi</p>
                        </div>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_payments'] }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.payments') }}?status=pending" class="btn btn-secondary" style="width: 100%;">
                    Verifikasi Sekarang
                </a>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">💳 Pembayaran Terbaru</h3>
            @if($recentPayments->isEmpty())
            <p class="text-center text-gray-500 py-8">Belum ada pembayaran</p>
            @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->user->full_name }}</td>
                            <td>{{ $payment->package->name ?? '-' }}</td>
                            <td><span class="badge badge-{{ $payment->status_color }}">{{ ucfirst($payment->status) }}</span></td>
                            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection
