<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Show user's coupons
     */
    public function index(Request $request)
    {
        $query = Auth::user()->coupons()->with('payment.package');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $coupons = $query->latest()->get();
        
        return view('dashboard.coupons', compact('coupons'));
    }
}
