<?php

use NextSemester\Courses\Course;

class CourseController extends \BaseController {

    public function index($cname){
    	
    	if(!Session::has('user_id')){
    		return Redirect::to('/login');
    	}

        $courseInfo = Course::where('cname', '=', $cname)->get()->first();

        return View::make('courses.create')->with('courseInfo', $courseInfo);
    }

    public function courselist(){

    	if(!Session::has('user_id')){
    		return Redirect::to('/login');
    	}
    	$courses = Course::all();

    	return View::make('courses.all')->with('courses', $courses);
    }
}

