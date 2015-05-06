<?php namespace NextSemester\Wall;

use Eloquent;

class WallPost extends Eloquent {

	protected $fillable = array("*");
	public $timestamps = false;
	protected $table = 'wallposts';

}
