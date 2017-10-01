<?php

namespace App\Http\Controllers\Admin;

use App\Donor;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Database\Query\Builder;
use Redirect;

class DonorController extends Controller
{

    public function index()
    {
        if (!Auth::user()->hasPermission('donors_view')) {
            return redirect()->route('admin.home');
        }

        $donors = Donor::select('*')
            ->selectSub(function (Builder $qb) {
                $qb->from('donations')
                    ->select(DB::raw('SUM(gross)'))
                    ->where('donor_id', '=', DB::raw('donors.id'));
            }, 'total')
            ->orderBy('total', 'desc')
            ->paginate(50);

        return view('admin.donors.index')
            ->with('donors', $donors);
    }

    public function show(Donor $donor)
    {
        if (!Auth::user()->hasPermission('donors_view')) {
            return redirect()->route('admin.home');
        }

        $donations = $donor->donations()->orderBy('created_at', 'desc')->get();

        return view('admin.donors.donor')
            ->with('donor', $donor)
            ->with('donations', $donations);
    }

}