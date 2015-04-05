<?php namespace NextSemester\Courses;

use Eloquent;

class SectionDays extends Eloquent {

    protected $guarded = array("*");
   
    protected $table = 'section_days';

}
