<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->identifier;
        
        // Find user by email or instagram
        $user = User::where('email', $identifier)
            ->orWhere('instagram', $identifier)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'identifier' => 'Username/Email atau password salah.',
            ])->withInput($request->only('identifier'));
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('dashboard.index'));
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:120|unique:users',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'instagram' => 'required|string|max:100|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
            'referral_code' => 'nullable|string|max:50|exists:users,own_referral_code',
            'terms' => 'accepted',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'instagram.unique' => 'Username Instagram sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'referral_code.exists' => 'Kode referral tidak valid.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        // Clean instagram username
        $instagram = ltrim($request->instagram, '@');

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'instagram' => $instagram,
            'referral_code' => $request->referral_code,
            'own_referral_code' => User::generateReferralCode(),
            'password' => $request->password,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Process logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda berhasil logout.');
    }
}
