<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\ATG\Repositories\Donation\EloquentDonation as Donations;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->user()->active) {
            return redirect()->route('home');
        }

        $news      = Article::take(5)->orderBy('created_at', 'desc')->get();
        $donations = Donation::with('donor')->orderBy('created_at', 'desc')->take(5)->get();

        // Get the PayPal balance
        $paypal  = new \App\ATG\Repositories\PayPal\Repository;
        $balance = $paypal->getBalance();

        // Get monthly donations total
        $donationsRepo = new Donations;
        $total         = $donationsRepo->monthlyTotal();

        return view('admin.panel')
            ->with('articles', $news)
            ->with('donations', $donations)
            ->with('balance', $balance)
            ->with('total', $total);
    }
}
