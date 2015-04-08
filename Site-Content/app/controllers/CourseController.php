<?php

use NextSemester\Courses\Course;

class CourseController extends \BaseController {

    public function index($cname){

        $courseInfo = Course::where('cname', '=', $cname)->get()->first();

        return View::make('courses.create')->with('courseInfo', $courseInfo);
    }

    public function courselist(){

    	$courses = Course::all();

    	return View::make('courses.all')->with('courses', $courses);
    }
}

