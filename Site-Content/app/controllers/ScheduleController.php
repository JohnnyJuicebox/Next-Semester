<?php

use NextSemester\Schedules\Schedule;
use NextSemester\Schedules\ScheduleSecRelation;	

class ScheduleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function auto()
	{
		$events = [];

		$events[] = Calendar::event(
		    'Event One', //event title
		    false, //full day event?
		    '2015-03-11T0800', //start time (you can also use Carbon instead of DateTime)
		    '2015-03-12T0800' //end time (you can also use Carbon instead of DateTime)
		);

        $currentDay = getdate()['wday'];
        $sectionDay = 2;
        $ct = date("Y-m-d", time() + ($sectionDay-$currentDay) * 86400);


        $events[] = Calendar::event(
		    "CS 280", //event title
		    false, //full day event?
		    new DateTime("$ct 12:00:00"), //start time (you can also use Carbon instead of DateTime)
		    new DateTime("$ct 15:00:00") //end time (you can also use Carbon instead of DateTime)
		);

		//EventModel implements MaddHatter\LaravelFullcalendar\Event

		$calendar = Calendar::addEvents($events) //add an array with addEvents
		    ->setOptions([ //set fullcalendar options
		        'firstDay' => 1,
		        'defaultView' => 'agendaWeek'
            ]);


        //return View::make('courses.create');
		return View::make('courses.auto');
		//return View::make('schedules.create', compact('calendar'));
	}

	public function manual(){

		return View::make('courses.manual');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	public function getCourseName($sectionId){

        $results = DB::select('SELECT * FROM course_sections WHERE id = ?', array($sectionId));
        
        if(count($results) == 0){
            return null;
        }
        return $results[0]->cname;
    }
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function manualstore()
	{
		if(Session::has('user_id')){
			
			$userid = Session::get('user_id');
			$secList = Input::get('secNames');
			
			$scheduleId = Schedule::where('user_id', '=', "$userid")->get()->all()[1]->id;
			$courseArr = array();
			
			foreach($secList as $val){
				DB::insert('INSERT INTO sche_sec_rel (schedule_id, section_id) VALUES(?, ?)', array($scheduleId, $val));
			}

			return Response::json(array());
		}

		return Response::json(array());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
