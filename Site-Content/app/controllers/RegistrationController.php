<?php

use NextSemester\Forms\RegistrationForm;
use NextSemester\Registration\RegisterUserCommand;
use NextSemester\Core\CommandBus;
use NextSemester\Users\User;

class RegistrationController extends BaseController {

	use CommandBus;

   /**
	* @var RegistrationForm 
	*/
	private $registrationForm;

	/**  
	 * Constructor
	 *
	 * @param RegistrationForm $registrationForm
	 */
	function __construct(RegistrationForm $registrationForm)
	{
		$this->registrationForm = $registrationForm;

		$this->beforeFilter('guest');
	}


	/**
	 * Show a form to register the user.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('registration.create');
	}

	/**
	 * Create a new NextSemester user.
	 *
	 * @return string
	 */
	public function store()
	{
		$this->registrationForm->validate(Input::all());

		extract(Input::only('username', 'email', 'password', 'major', 'fname',
			'lname'));

		$user = $this->execute(
			new RegisterUserCommand($username, $email, $password, $major, $fname, $lname)
		);


		Auth::login($user);
		$username = Input::get('username');

		$user = User::where('username', '=', "$username")->firstOrFail();
		Session::put('user_id', $user->id);
		$insertsql = 'INSERT INTO schedule(Name, user_id) VALUES(?, ?)';
		
		DB::insert($insertsql, array('Auto', $user->id));
		DB::insert($insertsql, array('Manual', $user->id));
		
		Flash::success('Glad to have you as a new NextSemester member!');

		return Redirect::home()->with('flash_messge', "Welcome aboard!");
	}

}
