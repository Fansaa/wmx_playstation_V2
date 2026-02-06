<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Show available packages
     */
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        $user = Auth::user();
        
        // Check if user has pending payment
        $pendingPayment = $user->payments()->where('status', 'pending')->first();
        
        return view('dashboard.packages', compact('packages', 'pendingPayment'));
    }

    /**
     * Show payment form
     */
    public function showPayment(Package $package)
    {
        return view('dashboard.payment', compact('package'));
    }

    /**
     * Store payment proof
     */
    public function storePayment(Request $request, Package $package)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'transaction_number' => 'required|string|max:255',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ], [
            'proof_image.required' => 'Bukti transfer wajib diupload.',
            'proof_image.image' => 'File harus berupa gambar.',
            'proof_image.max' => 'Ukuran file maksimal 5MB.',
        ]);

        // Store the proof image
        $path = $request->file('proof_image')->store('payment-proofs', 'public');

        Payment::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'account_name' => $request->account_name,
            'transaction_number' => $request->transaction_number,
            'proof_image' => $path,
        ]);

        return redirect()->route('dashboard.packages')
            ->with('success', 'Bukti pembayaran berhasil diupload. Tunggu verifikasi admin.');
    }

    /**
     * Show purchase history
     */
    public function history()
    {
        $payments = Auth::user()->payments()->with('package', 'coupons')->latest()->get();
        
        return view('dashboard.package-history', compact('payments'));
    }
}
