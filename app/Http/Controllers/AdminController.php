<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PlaySession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin dashboard with statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_packages' => Payment::where('status', 'approved')->count(),
            'total_referrals' => User::whereNotNull('referral_code')->count(),
            'total_revenue' => Payment::where('status', 'approved')
                ->join('packages', 'payments.package_id', '=', 'packages.id')
                ->sum('packages.price'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];

        // Get recent payments
        $recentPayments = Payment::with('user', 'package')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPayments'));
    }

    /**
     * List all users
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('instagram', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    /**
     * List all payments
     */
    public function payments(Request $request)
    {
        $query = Payment::with('user', 'package');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $payments = $query->latest()->paginate(20);
        
        return view('admin.payments', compact('payments'));
    }

    /**
     * Approve payment
     */
    public function approvePayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->withErrors(['error' => 'Pembayaran sudah diproses sebelumnya.']);
        }

        $package = $payment->package;
        
        $payment->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'regular_hours_given' => $package->regular_hours,
            'vip_hours_given' => $package->vip_hours,
            'expires_at' => now()->addDays($package->active_days),
        ]);

        // Generate coupons
        for ($i = 0; $i < $package->coupon_count; $i++) {
            Coupon::create([
                'user_id' => $payment->user_id,
                'payment_id' => $payment->id,
                'code' => Coupon::generateCode(),
                'status' => 'active',
                'expires_at' => now()->addDays($package->active_days),
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil disetujui.');
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->withErrors(['error' => 'Pembayaran sudah diproses sebelumnya.']);
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }

    /**
     * List all coupons
     */
    public function coupons(Request $request)
    {
        $query = Coupon::with('user', 'payment.package');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $coupons = $query->latest()->paginate(20);
        
        return view('admin.coupons', compact('coupons'));
    }

    /**
     * Draw winner
     */
    public function drawWinner()
    {
        $activeCoupons = Coupon::where('status', 'active')
            ->where('expires_at', '>=', now())
            ->with('user')
            ->get();

        if ($activeCoupons->isEmpty()) {
            return back()->withErrors(['error' => 'Tidak ada kupon aktif untuk diundi.']);
        }

        // Random winner
        $winner = $activeCoupons->random();
        
        return view('admin.winner', compact('winner', 'activeCoupons'));
    }
}
