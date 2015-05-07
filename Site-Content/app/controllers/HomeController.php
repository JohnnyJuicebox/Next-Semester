<?php

use NextSemester\Users\User;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function profile()
    {
    	$userInfo = User::where('id', '=', Session::get('user_id'))->get()->first();


        return View::make('profile.create')->with('userInfo', $userInfo);
    }
}
