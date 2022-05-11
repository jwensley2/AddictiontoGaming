<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use Auth;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('donations_view')) {
            return redirect()->route('admin.home');
        }

        $donations = Donation::with('donor')
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('admin.donations.list')
            ->with('donations', $donations);
    }
}
