<?php

class AccountController extends BaseController {

	public function getRegister()
	{
		return View::make('admin.account.register');
	}

	public function postRegister()
	{
		$user = new User;

		$user->username              = Input::get('username');
		$user->email                 = Input::get('email');
		$user->password              = Input::get('password');
		$user->password_confirmation = Input::get('password_confirmation');

		if ($user->save()) {
			return Redirect::route('login')
				->with('status', 'Your account has been created.');
		} else {
			return Redirect::route('register')
				->with('errors', $user->errors()->all());
		}
	}

	/**
	 * Display login form
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		return View::make('admin.account.login')
			->with('status', Session::get('status'));
	}

	/**
	 * Handle login
	 *
	 * @return Response
	 */
	public function postLogin()
	{
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username' => $username, 'password' => $password, 'active' => 1), true))
		{
			return Redirect::intended('admin');
		}
		else
		{
			return View::make('admin.account.login')
				->with('errors', array('Could not log you in.'));
		}
	}

	/**
	 * Display forgot password form
	 *
	 * @return Response
	 */
	public function getForgotPassword()
	{
		return View::make('admin.account.forgot_password');
	}

	/**
	 * Handle forgot password form
	 *
	 * @return Response
	 */
	public function postForgotPassword()
	{
		$response = Password::remind(Input::only('email'), function($message) {
			$message->subject('Password Reset');
		});

		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('errors', array(Lang::get($response)));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('status', Lang::get($response));
		}
	}

	/**
	 * Display reset password form
	 *
	 * @return Response
	 */
	public function getResetPassword($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('admin.account.reset_password')->with('token', $token);
	}

	/**
	 * Handle Reset Password Form
	 * @param type $token
	 * @return type
	 */
	public function postResetPassword()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = $password;

			$user->forceSave();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('errors', array(Lang::get($response)));

			case Password::PASSWORD_RESET:
				return Redirect::route('login');
		}
	}
}