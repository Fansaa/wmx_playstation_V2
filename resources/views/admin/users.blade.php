@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card mb-6">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <h2 class="text-2xl font-bold text-gray-800">👥 Kelola User</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← Kembali</a>
            </div>
        </div>

        <!-- Search -->
        <div class="card mb-6">
            <form method="GET" class="flex gap-4" style="flex-wrap: wrap;">
                <input type="text" name="search" class="form-input" style="flex: 1; min-width: 200px;" placeholder="Cari nama, email, atau Instagram..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
            </form>
        </div>

        <!-- Users List -->
        <div class="card">
            @if($users->isEmpty())
            <p class="text-center text-gray-500 py-8">Tidak ada user</p>
            @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Kontak</th>
                            <th>Referral</th>
                            <th>Paket</th>
                            <th>Kupon</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <p class="font-semibold">{{ $user->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ '@' . $user->instagram }}</p>
                            </td>
                            <td>
                                <p class="text-sm">{{ $user->email }}</p>
                                <p class="text-sm text-gray-500">{{ $user->phone ?? '-' }}</p>
                            </td>
                            <td>
                                <code class="text-xs">{{ $user->own_referral_code }}</code>
                                @if($user->referral_code)
                                <p class="text-xs text-gray-500">Dari: {{ $user->referral_code }}</p>
                                @endif
                            </td>
                            <td class="text-center">{{ $user->payments()->where('status', 'approved')->count() }}</td>
                            <td class="text-center">{{ $user->coupons()->count() }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $users->appends(request()->query())->links() }}</div>
            @endif
        </div>
    </div>
</main>
@endsection
