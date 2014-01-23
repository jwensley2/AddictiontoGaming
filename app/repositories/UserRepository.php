<?php

interface UserRepositoryInterface {
	/**
	 * Get a user by their ID
	 * @param  int $id
	 * @return Object
	 */
	public function find($id);

	public function findByUsername($username);

	public function create($user);

	public function update($user);

	public function delete($id);

	public function validForCreation($user);

	public function validForUpdate($user);

	public function permissions($id);
}