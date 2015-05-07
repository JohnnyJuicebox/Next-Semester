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

Route::post('wall/', [
    'as' => 'wall_path',
    'uses' => 'WallController@index'
]);

Route::get('wall/', [
    'as' => 'wall_all_path',
    'uses' => 'WallController@allPosts'
]);

Route::get('comments/', [
    'as' => 'coments_wall_path',
    'uses' => 'WallController@getComments'
]);

Route::post('comments/', [
    'as' => 'comments_post_wall_path',
    'uses' => 'WallController@postComments'
]);

App::after(function($request, $response)
{
    $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma','no-cache');
    $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
});

Route::get('profile', [
	'as' => 'profile_path',
	'uses' => 'HomeController@profile'
]);

