<?php namespace NextSemester\Schedules;

use Eloquent;

class Schedule extends Eloquent {

	public $timestamps = false;
	protected $guarded = array("id");
	protected $table = 'schedule';

}