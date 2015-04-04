<?php namespace NextSemester\Courses;

use Eloquent;

class CurrentCourses extends Eloquent {

    protected $guarded = array("*");
    protected $table = 'current_courses';

}
