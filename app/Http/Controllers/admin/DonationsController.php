<?php

namespace App\Http\Controllers\Admin;

use App\Donation;
use Auth;
use App\Http\Controllers\Controller;

class DonationsController extends Controller
{
    public function getIndex()
    {
        if (!Auth::user()->hasPermission('donations_view')) {
            return Redirect::route('admin');
        }

        $donations = Donation::with('donor')
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('admin.donations.list')
            ->with('donations', $donations);
    }
}