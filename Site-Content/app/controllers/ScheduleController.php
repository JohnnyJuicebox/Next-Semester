<?php

class ScheduleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = [];

		$events[] = Calendar::event(
		    'Event One', //event title
		    false, //full day event?
		    '2015-03-11T0800', //start time (you can also use Carbon instead of DateTime)
		    '2015-03-12T0800' //end time (you can also use Carbon instead of DateTime)
		);

		$events[] = Calendar::event(
		    "Valentine's Day", //event title
		    true, //full day event?
		    new DateTime('2015-03-14'), //start time (you can also use Carbon instead of DateTime)
		    new DateTime('2015-03-14') //end time (you can also use Carbon instead of DateTime)
		);

		//EventModel implements MaddHatter\LaravelFullcalendar\Event

		$calendar = Calendar::addEvents($events) //add an array with addEvents
		    ->setOptions([ //set fullcalendar options
		        'firstDay' => 1,
		        'defaultView' => 'agendaWeek'
		    ]); 

			return View::make('schedules.create', compact('calendar'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
