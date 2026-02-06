@extends('layouts.app')

@section('title', 'Login - WMX PLAY & WIN')

@section('content')
<main class="py-20">
    <div class="container" style="max-width: 28rem;">
        <div class="card">
            <div class="text-center mb-8">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem; color: white;">🔐</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Login</h2>
                <p class="text-gray-600">Masuk ke akun Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="identifier" class="form-label">Username Instagram atau Email</label>
                    <input 
                        type="text" 
                        id="identifier" 
                        name="identifier" 
                        class="form-input" 
                        placeholder="@username atau email@contoh.com"
                        value="{{ old('identifier') }}"
                        required
                    >
                    @error('identifier')
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
                        placeholder="Masukkan password Anda"
                        required
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" id="remember" name="remember" style="width: 1rem; height: 1rem;">
                    <label for="remember" class="text-sm text-gray-700">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Masuk
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-sky-500 font-semibold" style="text-decoration: none;">Daftar di sini</a>
            </p>
        </div>
    </div>
</main>
@endsection
