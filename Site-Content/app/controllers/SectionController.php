<?php

use NextSemester\Courses\CurrentCourses;
use NextSemester\Courses\CourseSections;
use NextSemester\Courses\SectionDays;

class SectionController extends \BaseController {

    public function index(){

        $secId = Input::get('secId');
        $cname = Input::get('cname');

        $timesList = SectionDays::where('sectionId', '=', "$secId")->get()->all();

        $events = [];
        $currentDay = getdate()['wday'];

        foreach($timesList as $key => $val){
            $secDay = $this->getCorrespondingDay($val["day"]);
            $startTime = $val["startTime"];
            $endTime = $val["endTime"];
            $ct = date("Y-m-d", time() + ($secDay-$currentDay) * 86400);
            $events[] = Calendar::event(
                "CS 280", //event title
                false, //full day event?
                new DateTime("$ct $startTime"), //start time (you can also use Carbon instead of DateTime)
                new DateTime("$ct $endTime") //end time (you can also use Carbon instead of DateTime)
            );
        }

        $calendar = Calendar::addEvents($events) //add an array with addEvents
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
                'defaultView' => 'agendaWeek'
            ]);

        //return null;
        return View::make('courses.create', compact('calendar'));
    }

    public function getCorrespondingDay($day){
        switch($day){
            case 'M':
                return 1;
                break;
            case 'T':
                return 2;
                break;
            case 'W':
                return 3;
                break;
            case 'R':
                return 4;
                break;
            case 'F':
                return 5;
                break;
            case 'S':
                return 6;
                break;
        }
    }

}

