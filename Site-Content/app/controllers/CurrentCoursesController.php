<?php

use NextSemester\Courses\CurrentCourses;
use NextSemester\Courses\CourseSections;
use NextSemester\Courses\SectionDays;

class CurrentCoursesController extends \BaseController {

    public function index(){

        $courseList = CurrentCourses::all();
        $array = array();
        $index = 0;

        foreach($courseList as $key => $value){
            $cname = $value->cname;
            $sec_info = CourseSections::where('cname', '=', "$cname")->get()->all();
            $ind = 0;
            $secArray = array();
            foreach($sec_info as $secKey => $secValue){
                $secNo = $secValue->id;
                $secDaysInfo = SectionDays::where('sectionId', '=', "$secNo")->get()->all();
                $secValue["timesInfo"] = $secDaysInfo;
                $secArray[$ind++] = $secValue;
            }
            $value["sec_info"] = $secArray;
            $array[$index++] = $value;
        }

        return Response::json($array);
    }
}

