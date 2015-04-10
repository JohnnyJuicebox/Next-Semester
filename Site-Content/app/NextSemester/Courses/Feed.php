<?php namespace NextSemester\Courses;

use Eloquent;

class Feed extends Eloquent {

	public $timestamps = false;
	protected $fillable = array("*");
	protected $table = 'feed';

}