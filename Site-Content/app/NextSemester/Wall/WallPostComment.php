<?php namespace NextSemester\Wall;

use Eloquent;

class WallPostComment extends Eloquent {

	protected $fillable = array("*");
	public $timestamps = false;
	protected $table = 'comments';

}
