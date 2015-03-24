<?php namespace NextSemester\Registration\Events;

 use NextSemester\Users\User;

 class UserRegistered {

 	public $user;

 	function __construct(User $user)
 	{
 		$this->user = $user;
 	}
 }