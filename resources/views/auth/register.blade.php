@extends('layouts.app')

@section('title', 'Daftar - WMX PLAY & WIN')

@section('content')
<main class="py-20">
    <div class="container" style="max-width: 32rem;">
        <div class="card">
            <div class="text-center mb-8">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem; color: white;">📝</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Akun</h2>
                <p class="text-gray-600">Bergabunglah dan mulai menang hari ini</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="full_name" class="form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        class="form-input" 
                        placeholder="Masukkan nama lengkap Anda"
                        value="{{ old('full_name') }}"
                        required
                    >
                    @error('full_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        class="form-textarea" 
                        rows="3"
                        placeholder="Masukkan alamat lengkap Anda"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Nomor WhatsApp</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="form-input" 
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('phone') }}"
                    >
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instagram" class="form-label">Username Instagram (untuk login)</label>
                    <input 
                        type="text" 
                        id="instagram" 
                        name="instagram" 
                        class="form-input" 
                        placeholder="@username_instagram"
                        value="{{ old('instagram') }}"
                        required
                    >
                    @error('instagram')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Minimal 6 karakter"
                        required
                        minlength="6"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input" 
                        placeholder="Ulangi password Anda"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="referral_code" class="form-label">Kode Referral (Opsional)</label>
                    <input 
                        type="text" 
                        id="referral_code" 
                        name="referral_code" 
                        class="form-input" 
                        placeholder="Masukkan kode referral jika ada"
                        value="{{ old('referral_code') }}"
                    >
                    <p class="text-sm text-gray-500 mt-1">Dapatkan bonus dari teman yang mengajak Anda!</p>
                    @error('referral_code')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="display: flex; align-items: start; gap: 0.75rem;">
                    <input type="checkbox" id="terms" name="terms" style="width: 1rem; height: 1rem; margin-top: 0.25rem;" required>
                    <label for="terms" class="text-sm text-gray-700" style="line-height: 1.5;">
                        Saya menyetujui 
                        <a href="https://docs.google.com/document/d/1qnGj2YTrZJwWb1OV1Zrv79CMCftlanBg5oVrmLn9bxo/edit?usp=sharing" 
                           target="_blank" 
                           class="text-sky-500 font-semibold" 
                           style="text-decoration: underline;">
                            syarat dan ketentuan
                        </a> 
                        yang berlaku.
                    </label>
                </div>
                @error('terms')
                    <p class="form-error" style="margin-top: -0.75rem; margin-bottom: 1rem;">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-sky-500 font-semibold" style="text-decoration: none;">Login di sini</a>
            </p>
        </div>
    </div>
</main>
@endsection
