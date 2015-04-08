<?php namespace NextSemester\Schedules;

use Eloquent;

class ScheduleSecRelation extends Eloquent {

	public $timestamps = false;
	protected $fillable = array("*");
	protected $table = 'sche_sec_rel';

}