@extends('layouts.app')

@section('title', 'WMX PLAY & WIN - Main, Kumpulkan, Menang!')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="py-20">
        <div class="container text-center">
            <div class="mb-8">
                <div style="width: 8rem; height: 8rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1.5rem; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(14,165,233,0.3);">
                    <span style="font-size: 3rem;">🎮</span>
                </div>
                <h1 style="font-size: 3.5rem; font-weight: 700; color: #0284c7; margin-bottom: 1rem;">WMX PLAY & WIN</h1>
                <div class="flex items-center justify-center gap-4 mb-6" style="font-size: 1.5rem; font-weight: 600;">
                    <span class="text-sky-500">Main</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-orange-500">Kumpulkan</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-sky-500">Menang!</span>
                </div>
                <p class="text-lg text-gray-600 mb-8" style="max-width: 48rem; margin: 0 auto;">
                    Hadir untuk merayakan dedikasi para pelanggan setia WMX — di mana setiap aksi kecil bisa membawa hasil luar biasa. Tunjukkan semangatmu, dan raih hadiah spektakulernya!
                </p>
                <div class="flex items-center justify-center gap-6" style="flex-wrap: wrap;">
                    <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem;">
                        🚀 GABUNG SEKARANG
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="font-size: 1.25rem; padding: 1rem 2rem;">
                        🎮 LOGIN AKUN WMX
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="container mb-8">
        <div class="grid grid-3">
            <div class="card" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 5rem; height: 5rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 2rem; color: white;">🎮</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Main Lebih Seru, Peluang Lebih Besar</h3>
                <p class="text-gray-600">Nikmati serunya bermain sambil membuka peluang luar biasa menuju kemenangan</p>
            </div>
            <div class="card" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 5rem; height: 5rem; background: linear-gradient(135deg, #fb923c, #ea580c); border-radius: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 2rem; color: white;">🏆</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Hadiah Spektakuler Menantimu</h3>
                <p class="text-gray-600">Hadiah eksklusif menanti mereka yang paling setia, dari PS 5, iPhone terbaru dan motor sport premium</p>
            </div>
            <div class="card" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 5rem; height: 5rem; background: linear-gradient(135deg, #a78bfa, #7c3aed); border-radius: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 2rem; color: white;">🚀</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Ajak Teman, Bonus Lebih Banyak</h3>
                <p class="text-gray-600">Main makin seru bareng teman! Ajak temanmu dan dapetin bonus ekstra di WMX.</p>
            </div>
        </div>
    </section>

    <!-- Prizes Section -->
    <section class="container mb-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-sky-600 mb-4">Hadiah Spektakuler Menanti!</h2>
            <p class="text-lg text-gray-600">Raih hadiah impianmu dengan bermain di WMX PLAY & WIN</p>
        </div>
        <div class="grid grid-3">
            <div class="card text-center" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 8rem; height: 8rem; background: linear-gradient(135deg, #4ade80, #16a34a); border-radius: 1.5rem; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 3rem;">🏍️</span>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Motor Sport Premium</h4>
                <p class="font-semibold text-green-600 mb-2">Ninja ZX-25RR</p>
                <p class="text-gray-600">Motor sport terdepan dengan performa luar biasa</p>
            </div>
            <div class="card text-center" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 8rem; height: 8rem; background: linear-gradient(135deg, #a78bfa, #7c3aed); border-radius: 1.5rem; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 3rem;">📱</span>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">iPhone Terbaru</h4>
                <p class="font-semibold" style="color: #7c3aed;">iPhone 15 Pro Max</p>
                <p class="text-gray-600">Smartphone flagship dengan teknologi terdepan</p>
            </div>
            <div class="card text-center" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 8rem; height: 8rem; background: linear-gradient(135deg, #60a5fa, #2563eb); border-radius: 1.5rem; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 3rem;">🎮</span>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Konsol Canggih</h4>
                <p class="font-semibold" style="color: #2563eb;">PlayStation 5</p>
                <p class="text-gray-600">Konsol gaming next-gen dengan grafis memukau</p>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="container" style="padding-bottom: 5rem;">
        <div style="background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 1.5rem; padding: 3rem; text-align: center; color: white;">
            <h3 class="text-3xl font-bold mb-4">Siap Meraih Kemenangan?</h3>
            <p class="text-lg mb-8" style="opacity: 0.9;">Bergabunglah sekarang dan mulai perjalananmu menuju hadiah spektakuler!</p>
            <div class="flex items-center justify-center gap-6" style="flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="btn" style="background: white; color: #0284c7; font-size: 1.125rem;">
                    🚀 DAFTAR GRATIS SEKARANG
                </a>
                <a href="{{ route('login') }}" class="btn" style="background: transparent; border: 2px solid white; color: white; font-size: 1.125rem;">
                    🎮 MASUK KE AKUN WMX
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
