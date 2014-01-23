<?php

class DBUserRepository implements UserRepository {

	/**
	 * Get a user by their ID
	 * @param  int    $id
	 * @return object
	 */
	public function find($id)
	{
		return User::find($id)->get();
	}

	/**
	 * Get a user by their username
	 * @param  string $username
	 * @return object
	 */
	public function findByUsername($username)
	{
		return User::whereUsername($username)->get();
	}

	/**
	 * Create a new user
	 * @param  object $user
	 * @return object
	 */
	public function create($user)
	{
		return User::create($user);
	}

	public function update($user)
	{
		$u = $this->find($user->id);

		if (isset($user->password))
		{

		}
	}
}