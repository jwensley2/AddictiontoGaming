<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ChangeUserPassword extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:change_password';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change a users password.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$username = $this->argument('username');

		$user = User::whereUsername($username)->first();

		// Make sure the user exists
		if ( ! $user)
		{
			$this->error("Could not finder user '{$username}'");
			exit;
		}

		$user->password              = $this->secret('Enter the new password:');
		$user->password_confirmation = $this->secret('Confirm the password:');

		if ( ! $user->save(User::$changePasswordRules))
		{
			foreach ($user->errors()->all() AS $error)
			{
				$this->error($error);
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('username', InputArgument::REQUIRED, 'The username of the user to whose password you want to change.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}