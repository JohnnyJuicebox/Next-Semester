<?php namespace NextSemester\Courses;

use Eloquent;

class CourseSections extends Eloquent {

    protected $guarded = array("*");
    protected $hidden = array("cname");
    protected $table = 'course_sections';

}
