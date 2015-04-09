<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Event::listen('NextSemester.Registration.Events.UserRegistered', function($event)
// {
// 	dd('send a notification email');
// });

Route::get('/', [
	'as' => 'home',
	'uses' => 'PagesController@home'
]);

/**
 * Registration
 */
Route::get('register', [
	'as' => 'register_path',
	'uses' => 'RegistrationController@create'
]);

Route::post('register', [
	'as' => 'register_path',
	'uses' => 'RegistrationController@store'
]);

/**
 * Sessions
 */
Route::get('login', [
	'as' => 'login_path',
	'uses' => 'SessionsController@create'
]);

Route::post('login', [
	'as' => 'login_path',
	'uses' => 'SessionsController@store'
]);

Route::get('logout', [
	'as' => 'logout_path',
	'uses' => 'SessionsController@destroy'
]);

/**
 * Statuses
 */
Route::get('statuses', 'StatusController@index');

/**
 * Schedule
 */
Route::get('autoschedule', [
	'as' => 'schedule_path',
	'uses' => 'ScheduleController@auto'
]);

Route::get('manualschedule', [
	'as' => 'schedule_manual_path',
	'uses' => 'ScheduleController@manual'
]);

Route::get('/courses', [
    'as' => 'courses_path',
    'uses' => 'CurrentCoursesController@index'
]);

Route::get('/searchCourse', [
	'as' => 'searchCourse_all',
	'uses' => 'SearchController@index'
]);

Route::get('/searchCourse/{cname}', [
	'as' => 'searchCourseCname',
	'uses' => 'SearchController@course'
]);

Route::get('/searchCourse/section/{sid}', [
	'as' => 'searchCourseCname',
	'uses' => 'SearchController@course_section'
]);

Route::get('/addSection', [
	'as' => 'add_section_path',
	'uses' => 'SectionController@index'
]);

// Route::get('/autogenerate', [
// 	'as' => 'auto_generator_path',
// 	'uses' => 'SectionController@logautogenerate'
// ]);

Route::get('/generate', [
	'as' => 'generator_path',
	'uses' => 'SectionController@schedule'
]);

Route::get('usermanualschedule', 'SectionController@getUserManualSchedule');
Route::get('userautoschedule', 'SectionController@getUserAutoSchedule');

Route::get('manualstore', 'ScheduleController@manualstore');

Route::get('course/{cid}', [
	'as' => 'course_path',
	'uses' => 'CourseController@index'
]);

Route::get('course/', [
	'as' => 'course_all_path',
	'uses' => 'CourseController@courselist'
	]);