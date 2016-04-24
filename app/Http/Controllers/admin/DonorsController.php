<?php

namespace App\Http\Controllers\Admin;

use App\Donor;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Redirect;

class DonorsController extends Controller
{

    public function getIndex()
    {
        if (!Auth::user()->hasPermission('donors_view')) {
            return Redirect::route('admin');
        }

        $donors = Donor::select(DB::raw('donors.*, SUM(gross) as total'))
            ->join('donations', 'donors.id', '=', 'donations.donor_id')
            ->groupBy('donors.id')
            ->orderBy('total', 'desc')
            ->paginate(50);

        return view('admin.donors.list')
            ->with('donors', $donors);
    }

    public function getDonor($id)
    {
        if (!Auth::user()->hasPermission('donors_view')) {
            return Redirect::route('admin');
        }

        $donor     = Donor::find($id);
        $donations = $donor->donations()->orderBy('created_at', 'desc')->get();

        return view('admin.donors.donor')
            ->with('donor', $donor)
            ->with('donations', $donations);
    }

}