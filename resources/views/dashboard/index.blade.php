@extends('layouts.app')

@section('title', 'Dashboard - WMX PLAY & WIN')

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
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard User</h2>
                    <p class="text-gray-600">Selamat datang, <span class="font-semibold text-sky-600">{{ $user->full_name }}</span>!</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="card mb-6">
            <div class="flex justify-between items-center mb-6" style="flex-wrap: wrap; gap: 1rem;">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <span>👤</span> Profil Saya
                </h3>
                <div class="flex gap-2" style="flex-wrap: wrap;">
                    <button onclick="document.getElementById('editModal').style.display='flex'" class="btn btn-primary text-sm">
                        ✏️ Edit Profil
                    </button>
                    <button onclick="document.getElementById('passwordModal').style.display='flex'" class="btn btn-secondary text-sm">
                        🔒 Ganti Password
                    </button>
                </div>
            </div>

            <div class="grid grid-2 gap-6">
                <!-- Personal Data -->
                <div style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 1rem; padding: 1.5rem;">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>📋</span> Data Pribadi
                    </h4>
                    <div class="grid gap-4">
                        <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ $user->full_name }}</p>
                        </div>
                        <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                            <p class="text-sm text-gray-500">WhatsApp</p>
                            <p class="font-semibold text-gray-800">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                            <p class="text-sm text-gray-500">Instagram</p>
                            <p class="font-semibold text-gray-800">{{ '@' . $user->instagram }}</p>
                        </div>
                        <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-semibold text-gray-800">{{ $user->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Referral Code -->
                <div style="background: linear-gradient(135deg, #fff7ed, #ffedd5); border-radius: 1rem; padding: 1.5rem;">
                    <div class="text-center">
                        <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #fb923c, #ea580c); border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 1.5rem; color: white;">🎯</span>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Kode Referral</h4>
                        <p class="text-sm text-gray-600 mb-4">Ajak teman dan dapatkan bonus kuota!</p>
                    </div>
                    <div style="background: white; border: 2px dashed #fb923c; border-radius: 0.75rem; padding: 1rem; text-align: center;">
                        <p class="text-sm text-gray-500 mb-2">Kode Unik Anda</p>
                        <div style="background: #fff7ed; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 0.75rem;">
                            <p class="text-xl font-bold text-orange-600" style="font-family: monospace;">{{ $user->own_referral_code }}</p>
                        </div>
                        <button onclick="copyReferral()" class="btn btn-secondary" style="width: 100%;">
                            📋 <span id="copyText">Salin Kode</span>
                        </button>
                    </div>
                    <div style="background: #fed7aa; border-radius: 0.75rem; padding: 0.75rem; margin-top: 1rem;">
                        <p class="text-sm text-orange-800 flex items-center gap-2">
                            <span>💡</span> Setiap referral = +2 jam bonus kuota!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card mb-6">
            <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span>📊</span> Statistik Akun
            </h4>
            <div class="grid grid-4">
                <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 1rem; padding: 1rem; text-center;">
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_packages'] }}</p>
                    <p class="text-sm text-gray-600">Total Paket</p>
                </div>
                <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border-radius: 1rem; padding: 1rem; text-center;">
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_coupons'] }}</p>
                    <p class="text-sm text-gray-600">Total Kupon</p>
                </div>
                <div style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); border-radius: 1rem; padding: 1rem; text-center;">
                    <p class="text-3xl font-bold" style="color: #7c3aed;">{{ $stats['total_referrals'] }}</p>
                    <p class="text-sm text-gray-600">Total Referral</p>
                </div>
                <div style="background: linear-gradient(135deg, #ffedd5, #fed7aa); border-radius: 1rem; padding: 1rem; text-center;">
                    <p class="text-3xl font-bold text-orange-600">{{ $quota['regular'] + $quota['vip'] }}</p>
                    <p class="text-sm text-gray-600">Sisa Kuota (Jam)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Edit Profil</h3>
                <button onclick="document.getElementById('editModal').style.display='none'" class="text-2xl text-gray-500">&times;</button>
            </div>
            <form action="{{ route('dashboard.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ $user->full_name }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">WhatsApp</label>
                    <input type="tel" name="phone" value="{{ $user->phone }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" value="{{ $user->instagram }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-textarea" rows="3">{{ $user->address }}</textarea>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn btn-outline" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Ganti Password</h3>
                <button onclick="document.getElementById('passwordModal').style.display='none'" class="text-2xl text-gray-500">&times;</button>
            </div>
            <form action="{{ route('dashboard.password.change') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="old_password" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required minlength="6">
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="document.getElementById('passwordModal').style.display='none'" class="btn btn-outline" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn btn-secondary" style="flex: 1;">Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Bottom Navigation -->
<nav class="dashboard-nav">
    <div class="dashboard-nav-items">
        <a href="{{ route('dashboard.index') }}" class="dashboard-nav-item active">
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
        <a href="{{ route('dashboard.coupons') }}" class="dashboard-nav-item">
            <span class="dashboard-nav-icon">🎫</span>
            <span class="dashboard-nav-label">Kupon</span>
        </a>
    </div>
</nav>
@endsection

@push('scripts')
<script>
function copyReferral() {
    navigator.clipboard.writeText('{{ $user->own_referral_code }}');
    document.getElementById('copyText').textContent = 'Tersalin!';
    setTimeout(() => {
        document.getElementById('copyText').textContent = 'Salin Kode';
    }, 2000);
}
</script>
@endpush
