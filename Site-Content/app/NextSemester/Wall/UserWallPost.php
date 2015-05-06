<?php namespace NextSemester\Wall;

use Eloquent;

class UserWallPost extends Eloquent {

	protected $guarded = array("*");
	public $timestamps = false;
	protected $table = 'user_wall_post';

}
