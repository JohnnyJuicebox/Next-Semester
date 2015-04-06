<?php

use NextSemester\Courses\CurrentCourses;
use NextSemester\Courses\CourseSections;
use NextSemester\Courses\SectionDays;
use NextSemester\Courses\SectionTimes;

class SearchController extends \BaseController {

    public function index(){

        $courseList = CurrentCourses::all();

        return Response::json($courseList);
    }

    public function course($cname){

        $sectionList = CourseSections::where('cname', '=', "$cname")->get()->all();

        return Response::json($sectionList);
    }

    public function course_section($sid){

        $timesList = SectionTimes::where('sectionId', '=', "$sid")->get()->all();

        return Response::json($timesList);
    }
}

