<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    /**
     * Dashboard index - Profile page
     */
    public function index()
    {
        $user = Auth::user();
        $quota = $user->getRemainingQuota();
        
        $stats = [
            'total_packages' => $user->payments()->where('status', 'approved')->count(),
            'total_coupons' => $user->coupons()->count(),
            'total_referrals' => $user->referrals()->count(),
            'remaining_quota' => $quota['regular'] + $quota['vip'],
        ];

        return view('dashboard.index', compact('user', 'quota', 'stats'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:120|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'instagram' => 'required|string|max:100|unique:users,instagram,' . $user->id,
        ]);

        $instagram = ltrim($request->instagram, '@');

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'instagram' => $instagram,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
