<?php

namespace App\ATG\Repositories\PayPal;

use PayPal\PayPalAPI\GetBalanceReq;
use PayPal\PayPalAPI\GetBalanceRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use Config;
use Cache;

class Repository
{
    public function __construct()
    {
        $config = Config::get('services.paypal');

        $this->service = new PayPalAPIInterfaceServiceService($config);
    }

    /**
     * Get the PayPal account balance
     *
     * @return int
     */
    public function getBalance()
    {
        return 0;

        if (Cache::has('paypal_balance')) {
            return Cache::get('paypal_balance');
        }

        $getBalanceRequest                = new GetBalanceRequestType();
        $getBalanceReq                    = new GetBalanceReq();
        $getBalanceReq->GetBalanceRequest = $getBalanceRequest;

        try {
            $getBalanceResponse = $this->service->GetBalance($getBalanceReq);
        } catch (Exception $ex) {
            \App::abort(500);
        }

        if (isset($getBalanceResponse)) {
            $balance = $getBalanceResponse->Balance->value;

            Cache::put('paypal_balance', $balance, 10);

            return $balance;
        }

        return null;
    }
}
