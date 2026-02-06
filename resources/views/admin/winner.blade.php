@extends('layouts.app')

@section('title', 'Undian - Admin')

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card mb-6">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <h2 class="text-2xl font-bold text-gray-800">🎰 Undian Pemenang</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← Kembali</a>
            </div>
        </div>

        <div class="card text-center">
            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 1rem; padding: 2rem; margin-bottom: 2rem;">
                <p class="text-4xl mb-4">🎉</p>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Hasil Undian</h3>
                <p class="text-gray-600 mb-4">Total kupon aktif: {{ $activeCoupons->count() }}</p>
            </div>

            <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 1rem; padding: 2rem;">
                <p class="text-lg text-gray-600 mb-2">🏆 PEMENANG:</p>
                <div style="background: white; border-radius: 1rem; padding: 1.5rem; display: inline-block;">
                    <p class="text-3xl font-bold text-green-600 mb-2" style="font-family: monospace;">{{ $winner->code }}</p>
                    <p class="font-semibold text-gray-800">{{ $winner->user->full_name }}</p>
                    <p class="text-sm text-gray-500">{{ '@' . $winner->user->instagram }}</p>
                    <p class="text-sm text-gray-500">{{ $winner->user->phone ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.draw') }}" class="btn btn-secondary">🔄 Undi Ulang</a>
            </div>
        </div>
    </div>
</main>
@endsection
