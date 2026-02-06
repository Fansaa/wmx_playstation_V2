@extends('layouts.app')

@section('title', 'Kelola Kupon - Admin')

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card mb-6">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <h2 class="text-2xl font-bold text-gray-800">🎫 Kelola Kupon</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← Kembali</a>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-6">
            <form method="GET" class="flex gap-4" style="flex-wrap: wrap;">
                <select name="status" class="form-select" style="width: auto;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Digunakan</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Coupons List -->
        <div class="card">
            @if($coupons->isEmpty())
            <p class="text-center text-gray-500 py-8">Tidak ada kupon</p>
            @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Kupon</th>
                            <th>User</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Berlaku Hingga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                        <tr>
                            <td><code class="font-bold">{{ $coupon->code }}</code></td>
                            <td>
                                <p class="font-semibold">{{ $coupon->user->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ '@' . $coupon->user->instagram }}</p>
                            </td>
                            <td>{{ $coupon->payment->package->name ?? '-' }}</td>
                            <td><span class="badge badge-{{ $coupon->status_color }}">{{ ucfirst($coupon->status) }}</span></td>
                            <td>{{ $coupon->expires_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $coupons->appends(request()->query())->links() }}</div>
            @endif
        </div>
    </div>
</main>
@endsection
