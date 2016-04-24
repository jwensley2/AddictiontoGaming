<?php

namespace App\Http\ViewComposers;

use App\ATG\Repositories\Donation\EloquentDonation as Donations;
use Illuminate\View\View;

class DonationsComposer
{
    /**
     * The donations repository implementation.
     *
     * @var Donations
     */
    protected $donations;

    /**
     * Create a new profile composer.
     *
     * @param  Donations $donations
     */
    public function __construct(Donations $donations)
    {
        // Dependencies automatically resolved by service container...
        $this->donations = $donations;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $donations['goal']    = $this->donations->monthlyGoal();
        $donations['total']   = $this->donations->monthlyTotal();
        $donations['percent'] = $this->donations->monthlyProgress();

        $view->with('donations', $donations);
    }
}