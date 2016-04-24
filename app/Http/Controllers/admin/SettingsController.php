<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings;
use Illuminate\Http\Request;
use Redirect;
use Session;

class SettingsController extends Controller
{
    public function getIndex()
    {
        $settings = new Settings();

        return view('admin.settings.index')
            ->with('messages', Session::get('messages'))
            ->with('settings', $settings);
    }

    public function postIndex(Request $request)
    {
        $rules = [
            'monthly_cost' => 'required|numeric|min:0',
        ];

        $this->validate($request, $rules);

        $settings               = new Settings();
        $settings->monthly_cost = $request->get('monthly_cost');

        return Redirect::action('Admin\SettingsController@getIndex')->with('messages', ['Settings have been saved']);
    }
}