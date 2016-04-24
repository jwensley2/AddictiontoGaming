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
     * @return Response
     */
    public function getIndex()
    {
        $user = Auth::user();

        return view('Admin.account.profile')
            ->with('user', $user)
            ->with('messages', Session::get('messages'));
    }

    /**
     * Handle profile form
     *
     * @return Response
     */
    public function postProfile(Request $request)
    {
        $user = Auth::user();

        $rules = User::$updateProfileRules;
        $rules['username'] .= ",{$user->id}";
        $rules['email'] .= ",{$user->id}";

        $this->validate($request, $rules);

        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->save();

        return Redirect::route('profile')
            ->with('messages', ['Your profile has been updated.']);

    }

    /**
     * Handle password change form
     *
     * @return Response
     */
    public function postChangePassword(Request $request)
    {
        $user = Auth::user();

        $rules = User::$changePasswordRules;

        $this->validate($request, $rules);

        $user->password              = $request->input('password');
        $user->password_confirmation = $request->input('password_confirmation');

        return Redirect::route('profile')
            ->with('messages', ['Password updated.']);

    }
}