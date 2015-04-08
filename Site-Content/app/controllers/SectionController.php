<?php

use NextSemester\Courses\CurrentCourses;
use NextSemester\Courses\CourseSections;
use NextSemester\Courses\SectionDays;
use Illuminate\Database\QueryException;
use NextSemester\Schedules\Schedule;

class SectionController extends \BaseController {

    public function index(){

        // $secId = Input::get('secId');
        // $cname = Input::get('cname');

        // $timesList = SectionDays::where('sectionId', '=', "$secId")->get()->all();

        // $events = [];
        // $currentDay = getdate()['wday'];

        // foreach($timesList as $key => $val){
        //     $secDay = $this->getCorrespondingDay($val["day"]);
        //     $startTime = $val["startTime"];
        //     $endTime = $val["endTime"];
        //     $ct = date("Y-m-d", time() + ($secDay-$currentDay) * 86400);
        //     $events[] = Calendar::event(
        //         "CS 280", //event title
        //         false, //full day event?
        //         new DateTime("$ct $startTime"), //start time (you can also use Carbon instead of DateTime)
        //         new DateTime("$ct $endTime") //end time (you can also use Carbon instead of DateTime)
        //     );
        // }

        // $calendar = Calendar::addEvents($events) //add an array with addEvents
        //     ->setOptions([ //set fullcalendar options
        //         'firstDay' => 1,
        //         'defaultView' => 'agendaWeek'
        //     ]);

        //return null;
        return View::make('courses.create');
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

    public function getDateInfo($day){
        
        $currentDay = getdate()['wday'];
        $secDay = $this->getCorrespondingDay($day);
        $currentTime = date("Y-m-d", time() + ($secDay-$currentDay) * 86400);
        
        return $currentTime;
    }

    public function schedule(){

        if(!Session::has('user_id')){
            return Response::json(array());
        }
        
        $option = Input::get('sOption');

        if(Request::ajax()){

            if($option == 1){
                $array = $this->generateSchedule();
            } else if($option == 2){
                $array = $this->generateTimingSchedule();
            }

      }

       return Response::json(array());
    }

    public function generateTimingSchedule(){

        $courses = Input::get('cnames');
        $indexes = array();
        $scheduleId = Schedule::where('user_id', '=', Session::get('user_id'))->get()->all()[0]->id;
        return $scheduleId;
        DB::delete('DELETE FROM sche_sec_rel WHERE schedule_id = ?', array($scheduleId));
        foreach($courses as $val){
            $indexes[$val] = 0;
        }

        $output = array();
        $ind = 0;
       
        $selectsql = 'SELECT id FROM course_sections WHERE cname = ? ORDER BY sec_no desc LIMIT ?,1';
        $insertsql = 'INSERT INTO sche_sec_rel(schedule_id, section_id) VALUES (?, ?)';
        $deletesql = 'DELETE FROM sche_sec_rel WHERE schedule_id = ? AND section_id = ?';

        $conflictsql = 'SELECT  * FROM conflict';  
        $str = "";

        for($index = 0; $index < count($courses); $index++){
            $results = DB::select($selectsql, array($courses[$index], $indexes[$courses[$index]]));
            if(count($results) != 0){
                try{
                    DB::insert($insertsql, array($scheduleId, $results[0]->id));
                } catch(Illuminate\Database\QueryException $e){
                    if($e->errorInfo[0] == '23000'){
                        $str = $str . "Duplicate exception<br/>";
                    } else {
                        $str = $str . "Not Duplicate exception<br/>";
                    }
                }
                //$str = //$str . "Insert: " . $courses[$index] . " " . $results[0]->id . "<br/>";
                $indexes[$courses[$index]] = $indexes[$courses[$index]] + 1;
                
                $conflictedRows = DB::select($conflictsql);
                $conflictCount = count($conflictedRows);

                if($conflictCount != 0){
                    while($conflictCount != 0){
                        //$str = //$str . "Conflict arisen<br/>";
                        $tmpCname = $this->getCourseName($conflictedRows[1]->sectionId);
                        $tmpSecId = $conflictedRows[1]->sectionId;

                        $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));

                        if(count($confResults) != 0){
                            
                            DB::delete($deletesql, array($scheduleId, $tmpSecId));
                            //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                            
                            try{
                                DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                             } catch(Illuminate\Database\QueryException $e){
                                if($e->errorInfo[0] == '23000'){
                                    $str = $str . "Duplicate exception<br/>";
                                } else {
                                    $str = $str . "Not Duplicate exception<br/>";
                                }
                            }
                            //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                            
                            $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                            $conflictedRows = DB::select($conflictsql);
                            $conflictCount = count($conflictedRows);
                        } else {
                            $tmpCname = $this->getCourseName($conflictedRows[0]->sectionId);
                            $tmpSecId = $conflictedRows[0]->sectionId;

                            $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));
                            if(count($confResults) != 0){
                                DB::delete($deletesql, array($scheduleId, $tmpSecId));
                            //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                            try{
                                DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                            } catch(Illuminate\Database\QueryException $e){
                                if($e->errorInfo[0] == '23000'){
                                    $str = $str . "Duplicate exception<br/>";
                                } else {
                                    $str = $str . "Not Duplicate exception<br/>";
                                }
                            }
                            //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                            
                            $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                            $conflictedRows = DB::select($conflictsql);
                            $conflictCount = count($conflictedRows);
                            }
                        }
                    }
                }
            }
        }

        $resultArray = array();

        return Response::json($resultArray);
    }


    public function generateSchedule(){

        if(!Session::has('user_id')){
            return Response::json(array());
        }

        if(Request::ajax()){

            $courses = Input::get('cnames');
            $indexes = array();
            $scheduleId = Schedule::where('user_id', '=', Session::get('user_id'))->get()->all()[0]->id;
            
            DB::delete('DELETE FROM sche_sec_rel WHERE schedule_id = ?', array($scheduleId));
            foreach($courses as $val){
                $indexes[$val] = 0;
            }

            $output = array();
            $ind = 0;
           
            $selectsql = 'SELECT id FROM course_sections WHERE cname = ? ORDER BY rating desc LIMIT ?,1';
            $insertsql = 'INSERT INTO sche_sec_rel(schedule_id, section_id) VALUES (?, ?)';
            $deletesql = 'DELETE FROM sche_sec_rel WHERE schedule_id = ? AND section_id = ?';

            $conflictsql = 'SELECT  * FROM conflict';  
            $str = "";

            for($index = 0; $index < count($courses); $index++){
                $results = DB::select($selectsql, array($courses[$index], $indexes[$courses[$index]]));
                if(count($results) != 0){
                    try{
                        DB::insert($insertsql, array($scheduleId, $results[0]->id));
                    } catch(Illuminate\Database\QueryException $e){
                        if($e->errorInfo[0] == '23000'){
                            $str = $str . "Duplicate exception<br/>";
                        } else {
                            $str = $str . "Not Duplicate exception<br/>";
                        }
                    }
                    //$str = //$str . "Insert: " . $courses[$index] . " " . $results[0]->id . "<br/>";
                    $indexes[$courses[$index]] = $indexes[$courses[$index]] + 1;
                    
                    $conflictedRows = DB::select($conflictsql);
                    $conflictCount = count($conflictedRows);

                    if($conflictCount != 0){
                        while($conflictCount != 0){
                            //$str = //$str . "Conflict arisen<br/>";
                            $tmpCname = $this->getCourseName($conflictedRows[1]->sectionId);
                            $tmpSecId = $conflictedRows[1]->sectionId;

                            $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));

                            if(count($confResults) != 0){
                                
                                DB::delete($deletesql, array($scheduleId, $tmpSecId));
                                //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                                
                                try{
                                    DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                                 } catch(Illuminate\Database\QueryException $e){
                                    if($e->errorInfo[0] == '23000'){
                                        $str = $str . "Duplicate exception<br/>";
                                    } else {
                                        $str = $str . "Not Duplicate exception<br/>";
                                    }
                                }
                                //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                                
                                $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                                $conflictedRows = DB::select($conflictsql);
                                $conflictCount = count($conflictedRows);
                            } else {
                                $tmpCname = $this->getCourseName($conflictedRows[0]->sectionId);
                                $tmpSecId = $conflictedRows[0]->sectionId;

                                $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));
                                if(count($confResults) != 0){
                                    DB::delete($deletesql, array($scheduleId, $tmpSecId));
                                //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                                try{
                                    DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                                } catch(Illuminate\Database\QueryException $e){
                                    if($e->errorInfo[0] == '23000'){
                                        $str = $str . "Duplicate exception<br/>";
                                    } else {
                                        $str = $str . "Not Duplicate exception<br/>";
                                    }
                                }
                                //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                                
                                $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                                $conflictedRows = DB::select($conflictsql);
                                $conflictCount = count($conflictedRows);
                                }
                            }
                        }
                    }
                }
            }

            $resultArray = array();

            return Response::json($resultArray);
         }

         return Response::json(array());
    }

    public function getUserManualSchedule(){

        if(Session::has('user_id')){
            $scheduleId = Schedule::where('user_id', '=', Session::get('user_id'))->get()->all()[1]->id;

            $scheduleResults = DB::select('SELECT section_id FROM sche_sec_rel WHERE schedule_id = ?', array($scheduleId));
            $resultArray = array();
            $ind = 0;
            for($index = 0; $index < count($scheduleResults); $index++){
                $secId = $scheduleResults[$index]->section_id;
                $courseResults = DB::select('SELECT sectionId, cname, day, startTime, endTime, roomInfo, fname, lname, rating FROM section_times JOIN course WHERE course.id = section_times.courseId AND section_times.sectionId = ?', array($secId));

                for($j = 0; $j < count($courseResults); $j++){

                    if(intval($courseResults[$j]->rating) > 0){
                        $resultArray[$ind++] = array("title" => $courseResults[$j]->cname . " " . round($courseResults[$j]->rating, 2),
                                                "url" => "course/" . $courseResults[$j]->cname,   
                                                "id" => $courseResults[$j]->sectionId,
                                                "start" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->startTime,
                                                "end" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->endTime,
                                                "description" => $this->checkIfExists($courseResults[$j]->fname) . " " . $this->checkIfExists($courseResults[$j]->lname) . "<br/>" . $this->checkIfExists($courseResults[$j]->roomInfo));
                    } else {
                        $resultArray[$ind++] = array("title" => $courseResults[$j]->cname,
                                                "url" => "course/" . $courseResults[$j]->cname,
                                                "id" => $courseResults[$j]->sectionId,
                                                "start" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->startTime,
                                                "end" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->endTime,
                                               "description" => $this->checkIfExists($courseResults[$j]->fname) . " " . $this->checkIfExists($courseResults[$j]->lname) . "<br/>" . $this->checkIfExists($courseResults[$j]->roomInfo));
                    }
                }
            }

            return Response::json($resultArray);
        }
        return Response::json(array());
    }

    public function getUserAutoSchedule(){

        if(Session::has('user_id')){
            $scheduleId = Schedule::where('user_id', '=', Session::get('user_id'))->get()->all()[0]->id;

            $scheduleResults = DB::select('SELECT section_id FROM sche_sec_rel WHERE schedule_id = ?', array($scheduleId));
            $resultArray = array();
            $ind = 0;
            for($index = 0; $index < count($scheduleResults); $index++){
                $secId = $scheduleResults[$index]->section_id;
                $courseResults = DB::select('SELECT sectionId, cname, day, startTime, endTime, roomInfo, fname, lname, rating FROM section_times JOIN course WHERE course.id = section_times.courseId AND section_times.sectionId = ?', array($secId));

                for($j = 0; $j < count($courseResults); $j++){

                    if(intval($courseResults[$j]->rating) > 0){
                        $resultArray[$ind++] = array("title" => $courseResults[$j]->cname . " " . round($courseResults[$j]->rating, 2),
                                                "url" => "course/" . $courseResults[$j]->cname,   
                                                "id" => $courseResults[$j]->sectionId,
                                                "start" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->startTime,
                                                "end" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->endTime,
                                               "description" => $this->checkIfExists($courseResults[$j]->fname) . " " . $this->checkIfExists($courseResults[$j]->lname) . "<br/>" . $this->checkIfExists($courseResults[$j]->roomInfo));
                    } else {
                        $resultArray[$ind++] = array("title" => $courseResults[$j]->cname,
                                                "id" => $courseResults[$j]->sectionId,
                                                "url" => "course/" . $courseResults[$j]->cname,
                                                "start" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->startTime,
                                                "end" => $this->getDateInfo($courseResults[$j]->day) . " " . $courseResults[$j]->endTime,
                                                "description" => $this->checkIfExists($courseResults[$j]->fname) . " " . $this->checkIfExists($courseResults[$j]->lname) . "<br/>" . $this->checkIfExists($courseResults[$j]->roomInfo));
                    }
                }
            }

            return Response::json($resultArray);
        }
        return Response::json(array());
    }

    public function checkIfExists($val){
        if($val == null){
            return "";
        }

        return $val;
    }
    public function manualgenerate(){

        return View::make('courses.manual');
    }

    public function logautogenerate(){

        $courses = Input::get('cnames');
        $indexes = array();
        $scheduleId = 1;

        foreach($courses as $val){
            $indexes[$val] = 0;
        }

        $output = array();
        $ind = 0;
       
        $selectsql = 'SELECT id FROM course_sections WHERE cname = ? ORDER BY rating desc LIMIT ?,1';
        $insertsql = 'INSERT INTO sche_sec_rel(schedule_id, section_id) VALUES (?, ?)';
        $deletesql = 'DELETE FROM sche_sec_rel WHERE schedule_id = ? AND section_id = ?';

        $conflictsql = 'SELECT  * FROM conflict';  
        //$str = "";

        for($index = 0; $index < count($courses); $index++){
            $results = DB::select($selectsql, array($courses[$index], $indexes[$courses[$index]]));
            if(count($results) != 0){
                try{
                    DB::insert($insertsql, array($scheduleId, $results[0]->id));
                } catch(Illuminate\Database\QueryException $e){
                    if($e->errorInfo[0] == '23000'){
                        //$str = //$str . "Duplicate exception<br/>";
                    } else {
                        //$str = //$str . "Not Duplicate exception<br/>";
                    }
                }
                //$str = //$str . "Insert: " . $courses[$index] . " " . $results[0]->id . "<br/>";
                $indexes[$courses[$index]] = $indexes[$courses[$index]] + 1;
                
                $conflictedRows = DB::select($conflictsql);
                $conflictCount = count($conflictedRows);

                if($conflictCount != 0){
                    while($conflictCount != 0){
                        //$str = //$str . "Conflict arisen<br/>";
                        $tmpCname = $this->getCourseName($conflictedRows[1]->sectionId);
                        $tmpSecId = $conflictedRows[1]->sectionId;

                        $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));

                        if(count($confResults) != 0){
                            
                            DB::delete($deletesql, array($scheduleId, $tmpSecId));
                            //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                            
                            try{
                            DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                             } catch(Illuminate\Database\QueryException $e){
                                if($e->errorInfo[0] == '23000'){
                                    //$str = //$str . "Duplicate exception<br/>";
                                } else {
                                    //$str = //$str . "Not Duplicate exception<br/>";
                                }
                            }
                            //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                            
                            $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                            $conflictedRows = DB::select($conflictsql);
                            $conflictCount = count($conflictedRows);
                        } else {
                            $tmpCname = $this->getCourseName($conflictedRows[0]->sectionId);
                            $tmpSecId = $conflictedRows[0]->sectionId;

                            $confResults = DB::select($selectsql, array($tmpCname, $indexes[$tmpCname]));
                            if(count($confResults) != 0){
                                DB::delete($deletesql, array($scheduleId, $tmpSecId));
                            //$str = //$str . "Delete: " . $tmpCname . " " . $tmpSecId . "<br/>";
                            try{
                            DB::insert($insertsql, array($scheduleId, $confResults[0]->id));
                            } catch(Illuminate\Database\QueryException $e){
                                if($e->errorInfo[0] == '23000'){
                                    //$str = //$str . "Duplicate exception<br/>";
                                } else {
                                    //$str = //$str . "Not Duplicate exception<br/>";
                                }
                            }
                            //$str = //$str . "Insert: " . $tmpCname . " " . $confResults[0]->id . "<br/>";
                            
                            $indexes[$tmpCname] = $indexes[$tmpCname] + 1;
                            $conflictedRows = DB::select($conflictsql);
                            $conflictCount = count($conflictedRows);
                            }
                        }
                    }
                }
            }
        }

        return $str;//Response::json(array("operation" => "success"));
    }

    public function getRating($sectionId){
        
        $results = DB::select('SELECT * FROM course_sections WHERE id = ?', array($sectionId));
        
        if(count($results) == 0){
            return null;
        }
        return $results[0]->rating;
    }

    public function getCourseName($sectionId){

        $results = DB::select('SELECT * FROM course_sections WHERE id = ?', array($sectionId));
        
        if(count($results) == 0){
            return null;
        }
        return $results[0]->cname;
    }

}

