<?php

use NextSemester\Forms\SignInForm;
use NextSemester\Users\User;

class SessionsController extends \BaseController {

	private $signInForm;

	public function __construct(SignInForm $signInForm)
	{
		$this->signInForm = $signInForm;

		$this->beforeFilter('guest', ['except' => 'destroy']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// fetch the form input
		// validate the form
		// if invalid, then go back
		$formData = Input::only('email', 'password');
		$this->signInForm->validate($formData);
		$email = Input::get('email');

		// if is valid, then try to sign in
		if(Auth::attempt($formData))
		{
			Flash::message('Welcome back!');
			$user = User::where('email', '=', "$email")->firstOrFail();
			Session::put('user_id', $user->id);
			// redirect to statuses
			return Redirect::intended('autoschedule');
		} else {
			Flash::alert('Your username/password combination was incorrect');
			return Redirect::to('login');
		}
	}

	/**
	 * Log a user out of NextSemester.
	 *
	 * @return mixed
	 */
	public function destroy()
	{
		Auth::logout();
		Session::flush();
		Flash::success('You have now been logged out.');
		return Redirect::home();
	}

}
