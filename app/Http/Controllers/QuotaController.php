<?php

namespace App\Http\Controllers;

use App\Models\PlaySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotaController extends Controller
{
    /**
     * Show quota overview
     */
    public function index()
    {
        $user = Auth::user();
        $quota = $user->getRemainingQuota();
        
        // Get active payment with quota
        $activePayment = $user->payments()
            ->where('status', 'approved')
            ->where('expires_at', '>=', now())
            ->orderBy('expires_at', 'asc')
            ->first();
        
        // Get play sessions history
        $sessions = $user->playSessions()
            ->with('payment')
            ->latest()
            ->take(10)
            ->get();
        
        $branches = PlaySession::getBranches();
        
        return view('dashboard.quota', compact('user', 'quota', 'activePayment', 'sessions', 'branches'));
    }

    /**
     * Confirm quota usage (request to play)
     */
    public function confirmUsage(Request $request)
    {
        $request->validate([
            'branch' => 'required|in:' . implode(',', PlaySession::getBranches()),
            'type' => 'required|in:regular,vip',
            'duration_hours' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $quota = $user->getRemainingQuota();
        $type = $request->type;
        $duration = $request->duration_hours;

        // Check if user has enough quota
        if ($quota[$type] < $duration) {
            return back()->withErrors(['quota' => 'Kuota tidak mencukupi. Sisa kuota ' . $type . ': ' . $quota[$type] . ' jam.']);
        }

        // Get an active payment to associate with
        $activePayment = $user->payments()
            ->where('status', 'approved')
            ->where('expires_at', '>=', now())
            ->first();

        if (!$activePayment) {
            return back()->withErrors(['quota' => 'Tidak ada paket aktif. Silakan beli paket terlebih dahulu.']);
        }

        PlaySession::create([
            'user_id' => $user->id,
            'payment_id' => $activePayment->id,
            'branch' => $request->branch,
            'type' => $type,
            'duration_hours' => $duration,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan bermain berhasil dikirim. Tunggu konfirmasi dari admin cabang.');
    }

    /**
     * Show play history
     */
    public function history()
    {
        $sessions = Auth::user()->playSessions()
            ->with('payment.package')
            ->latest()
            ->paginate(20);
        
        return view('dashboard.quota-history', compact('sessions'));
    }
}
