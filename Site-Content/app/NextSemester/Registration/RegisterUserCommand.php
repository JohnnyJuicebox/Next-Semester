<?php namespace NextSemester\Registration;

class RegisterUserCommand{

	public $username;
	public $email;
	public $password;
	public $major;
	public $fname;
	public $lname;


	function __construct($username, $email, $password, $major, $fname, $lname)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->major = $major;
		$this->fname = $fname;
		$this->lname = $lname;
	}
}