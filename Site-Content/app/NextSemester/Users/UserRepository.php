<?php namespace NextSemester\Users;

class UserRepository {

	/**
	 * Persist a user
	 *
	 * @param User $user 
	 * @return mixed
	 *
	 */
	public function save(User $user)
	{
		return $user->save();
	}
}