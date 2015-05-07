<?php namespace NextSemester\Wall;

use Eloquent;

class WallComment extends Eloquent {

	protected $guarded = array("*");
	public $timestamps = false;
	protected $table = 'wall_comment_view';

}
