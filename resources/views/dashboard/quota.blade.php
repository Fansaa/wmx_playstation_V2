@extends('layouts.app')

@section('title', 'Kuota Main PS - WMX PLAY & WIN')

@push('styles')
<style>
    body { padding-bottom: 5rem; }
</style>
@endpush

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-6">
                <span>🎮</span> Kuota Main PlayStation
            </h2>

            <!-- Quota Summary -->
            <div class="grid grid-3 gap-4 mb-6">
                <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 1rem; padding: 1.5rem;">
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 1.5rem;">📦</span>
                        <p class="text-2xl font-bold text-blue-600">{{ $quota['regular'] + $quota['vip'] }}</p>
                    </div>
                    <h4 class="font-bold text-gray-800">Total Kuota</h4>
                    <p class="text-sm text-gray-600">Jam tersedia</p>
                </div>
                <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 1rem; padding: 1.5rem;">
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 1.5rem;">⏰</span>
                        <p class="text-2xl font-bold text-green-600">{{ $quota['regular'] }}</p>
                    </div>
                    <h4 class="font-bold text-gray-800">Kuota Reguler</h4>
                    <p class="text-sm text-gray-600">Jam tersisa</p>
                </div>
                <div style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); border-radius: 1rem; padding: 1.5rem;">
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 1.5rem;">👑</span>
                        <p class="text-2xl font-bold" style="color: #7c3aed;">{{ $quota['vip'] }}</p>
                    </div>
                    <h4 class="font-bold text-gray-800">Kuota VIP</h4>
                    <p class="text-sm text-gray-600">Jam tersisa</p>
                </div>
            </div>

            @if($activePayment)
            <div style="background: #dcfce7; border: 1px solid #86efac; border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem;">
                <p class="text-green-800 flex items-center gap-2">
                    <span>✅</span> Paket aktif hingga: <strong>{{ $activePayment->expires_at->format('d M Y') }}</strong>
                </p>
            </div>
            @else
            <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem;">
                <p class="text-red-800 flex items-center gap-2">
                    <span>⚠️</span> Tidak ada paket aktif. <a href="{{ route('dashboard.packages') }}" class="font-semibold underline">Beli paket sekarang</a>
                </p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="grid grid-2 gap-4">
                <button onclick="document.getElementById('usageModal').style.display='flex'" class="btn" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; padding: 1rem;">
                    ✅ Konfirmasi Penggunaan Kuota
                </button>
                <button onclick="document.getElementById('contactModal').style.display='flex'" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 1rem;">
                    📞 Hubungi Admin Cabang
                </button>
            </div>
        </div>

        <!-- Play History -->
        <div class="card">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span>📊</span> Riwayat Bermain
            </h3>

            @if($sessions->isEmpty())
            <div class="text-center" style="padding: 3rem;">
                <p class="text-4xl mb-4">🎮</p>
                <h4 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Riwayat Bermain</h4>
                <p class="text-gray-600">Mulai bermain PlayStation untuk melihat riwayat Anda di sini</p>
            </div>
            @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Durasi</th>
                            <th>Tipe</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $session->branch }}</td>
                            <td>{{ $session->duration_hours }} Jam</td>
                            <td><span class="badge badge-{{ $session->type == 'vip' ? 'blue' : 'gray' }}">{{ ucfirst($session->type) }}</span></td>
                            <td><span class="badge badge-{{ $session->status_color }}">{{ ucfirst($session->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Usage Confirmation Modal -->
    <div id="usageModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="text-center mb-6">
                <div style="width: 4rem; height: 4rem; background: #dcfce7; border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem;">🎮</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Penggunaan Kuota</h3>
                <p class="text-gray-600">Pastikan Anda sudah di cabang dan siap bermain</p>
            </div>
            <form action="{{ route('dashboard.quota.confirm') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Pilih Cabang</label>
                    <select name="branch" class="form-select" required>
                        <option value="">Pilih cabang tempat bermain</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch }}">{{ $branch }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe Bermain</label>
                    <select name="type" class="form-select" required>
                        <option value="">Pilih tipe bermain</option>
                        <option value="regular">Reguler</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Estimasi Durasi (Jam)</label>
                    <select name="duration_hours" class="form-select" required>
                        <option value="">Pilih durasi bermain</option>
                        @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Jam</option>
                        @endfor
                    </select>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="document.getElementById('usageModal').style.display='none'" class="btn btn-outline" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn" style="flex: 1; background: linear-gradient(135deg, #22c55e, #16a34a); color: white;">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contact Admin Modal -->
    <div id="contactModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="text-center mb-6">
                <div style="width: 4rem; height: 4rem; background: #dbeafe; border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem;">📞</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hubungi Admin Cabang</h3>
                <p class="text-gray-600">Pilih cabang untuk menghubungi admin</p>
            </div>
            <div class="grid gap-2">
                <a href="https://wa.me/6281324751827" target="_blank" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #dcfce7; border-radius: 0.75rem; text-decoration: none; color: inherit;">
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <div>
                            <p class="font-semibold">Admin Serang</p>
                            <p class="text-sm text-gray-600">0813-2475-1827</p>
                        </div>
                    </div>
                    <span>💬</span>
                </a>
                <a href="https://wa.me/6282241528480" target="_blank" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #dcfce7; border-radius: 0.75rem; text-decoration: none; color: inherit;">
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <div>
                            <p class="font-semibold">Admin Semarang</p>
                            <p class="text-sm text-gray-600">0822-4152-8480</p>
                        </div>
                    </div>
                    <span>💬</span>
                </a>
                <a href="https://wa.me/6285840312799" target="_blank" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #dcfce7; border-radius: 0.75rem; text-decoration: none; color: inherit;">
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <div>
                            <p class="font-semibold">Admin Palembang</p>
                            <p class="text-sm text-gray-600">0858-4031-2799</p>
                        </div>
                    </div>
                    <span>💬</span>
                </a>
                <a href="https://wa.me/6287715245676" target="_blank" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #dcfce7; border-radius: 0.75rem; text-decoration: none; color: inherit;">
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <div>
                            <p class="font-semibold">Admin Purwodadi</p>
                            <p class="text-sm text-gray-600">0877-1524-5676</p>
                        </div>
                    </div>
                    <span>💬</span>
                </a>
            </div>
            <button onclick="document.getElementById('contactModal').style.display='none'" class="btn btn-outline mt-4" style="width: 100%;">Tutup</button>
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
        <a href="{{ route('dashboard.quota') }}" class="dashboard-nav-item active">
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
