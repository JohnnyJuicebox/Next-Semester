<?php namespace NextSemester\Courses;

use Eloquent;

class SectionTimes extends Eloquent {

    protected $guarded = array("*");
    protected $table = 'section_times';

}
