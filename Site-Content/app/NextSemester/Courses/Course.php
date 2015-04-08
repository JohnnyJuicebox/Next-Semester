<?php namespace NextSemester\Courses;

use Eloquent;

class Course extends Eloquent {

	public $timestamps = false;
	protected $guarded = array("*");
	protected $table = 'course';

}