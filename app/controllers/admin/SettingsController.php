<?php

class SettingsController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	// ------------------------------------------------------------------------

	public function getIndex()
	{
		$settings = new Settings();

		return View::make('admin.settings.index')
			->with('messages', Session::get('messages'))
			->with('settings', $settings);
	}

	// ------------------------------------------------------------------------

	public function postIndex()
	{
		$rules = array(
			'monthly_cost' => 'required|numeric'
		);

		$data = Input::all();

		$v = Validator::make($data, $rules);

		if ($v->fails())
		{
			return Redirect::action('SettingsController@getIndex')->withErrors($v);
		}

		$settings = new Settings();

		$settings->monthly_cost = $data['monthly_cost'];

		return Redirect::action('SettingsController@getIndex')->with('messages', array('Settings have been saved'));
	}
}