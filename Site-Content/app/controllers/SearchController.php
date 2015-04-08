<?php

use NextSemester\Courses\CurrentCourses;
use NextSemester\Courses\CourseSections;
use NextSemester\Courses\SectionDays;
use NextSemester\Courses\SectionTimes;

class SearchController extends \BaseController {

    public function index(){

        $courseList = array();

        if(Request::ajax()){
            if(Session::has('user_id')){
                $courseList = CurrentCourses::all();
                return Response::json($courseList);
            }
        }
       
       return $courseList;
    }

    public function course($cname){

        $sectionList = array();

        //if(Request::ajax()){
            if(Session::has('user_id')){
                $sectionList = CourseSections::where('cname', '=', "$cname")->get()->all();
                return Response::json($sectionList);
            }
        //}

        return Response::json($sectionList);
    }

    public function course_section($sid){

        $timesList = array();
        
        //if(Request::ajax()){
            if(Session::has('user_id')){
                $timesList = SectionTimes::where('sectionId', '=', "$sid")->get()->all();
                return Response::json($timesList);
            }
        //}

        return Response::json($timesList);
    }
}

