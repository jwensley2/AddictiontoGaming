<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use Session;

class AccountController extends Controller
{

    /**
     * Display the user's profile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return view('admin.account.edit')
            ->with('user', $user)
            ->with('messages', Session::get('messages'));
    }

    /**
     * Handle profile form
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules             = User::$updateProfileRules;
        $rules['username'] .= ",{$user->id}";
        $rules['email']    .= ",{$user->id}";

        $this->validate($request, $rules);

        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->save();

        return redirect()->route('admin.account.edit', [$user])
            ->with('messages', ['Your profile has been updated.']);

    }

    /**
     * Handle password change form
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $rules = User::$changePasswordRules;

        $this->validate($request, $rules);

        $user->password              = $request->input('password');
        $user->password_confirmation = $request->input('password_confirmation');

        return redirect()->route('admin.account.edit', [$user])
            ->with('messages', ['Password updated.']);

    }
}