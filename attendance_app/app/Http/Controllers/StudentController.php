<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Session;
use App\Hall;
use App\Blocking_device_ids;
use App\attendance_sessions;
class StudentController extends Controller
{
    public function login(Request $request){
        try {
            $data = Student::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->seating_number == $request->seating_number 
                && $data[$i]->national_id == $request->national_id ){
                    if($data[$i]->device_id !=$request->device_id ){
                        $data[$i]->device_id =$request->device_id;
                        $data[$i]->save();
                    }
                    return 'successfully';   
                }
            }
            return 'Not Found';
        }
        catch (\Exception $e){
            return 'wrong';
        }
    }
    public function get_student($id){
        try {
            $data = Student::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->id == $id){
                    return response()->json($data[$i]);
                }
            }
         }
        catch (\Exception $e){
            return 'Not Found';
        }
    }
    public function get_sessions(){
        try {
            $data_sessions = Session::all();
            $data_halls = Hall::all();
            if(sizeof($data_sessions) == 0){
                return 'No Data found';
            }
            date_default_timezone_set("Africa/Cairo");
            $data = array();
            for($i = 0 ;$i< sizeof($data_sessions);$i++){
                if($data_sessions[$i]->date == date("j/n/Y")){
                    
                    $first_time = strtotime($data_sessions[$i]->start_time) + 
                    $data_sessions[$i]->registeration_time * 60;
                    $second_time = strtotime(date("H:i"));
                    if($first_time >= $second_time ){
                        for($j = 0 ;$j<sizeof($data_halls) ; $j++){
                            if($data_halls[$j]->name == $data_sessions[$i]->hall_name){
                                $session = $data_sessions[$i];
                                $session['longitude'] = $data_halls[$j]->longitude;
                                $session['latitude'] = $data_halls[$j]->latitude;
                                array_push($data,$session);
                                break;
                            }
                        }
                    }
                }
            }
            return response()->json($data);
         }
        catch (\Exception $e){
            return 'Error';
        }
    }
    public function get_sessions_student($seating_number){
        try {
            $data_attendance = attendance_sessions::all();
            $data_sessions = Session::all();
            if(sizeof($data_attendance) == 0){
                return 'No Data found';
            }
            $data = array();
            for($i = 0 ;$i< sizeof($data_attendance);$i++){
                    if($data_attendance[$i]->student_seating_number == 
                        $seating_number){
                            for($j = 0 ;$j< sizeof($data_sessions) ;$j++){
                                if($data_attendance[$i]->session_id ==
                                $data_sessions[$j]->id){
                                    array_push($data,$data_sessions[$j]);
                                    break;
                                }
                            }
                        }
            }
            return response()->json($data);
         }
        catch (\Exception $e){
            return 'Error';
        }
    }

    public function attend_session(Request $request){
        try {
            $data = Blocking_device_ids::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->device_id ==$request->device_id
                  && $data[$i]->session_id  == $request->session_id ){
                    return 'not allowed';
                }
            }
            
            // block thid device id to not allowed others register with this id
            $block = new Blocking_device_ids;
            $block->device_id = $request->device_id;
            $block->session_id = $request->session_id;
            $block->save();
            // add registeration 
            $regist = new attendance_sessions;
            $regist->device_id = $request->device_id;
            $regist->session_id = $request->session_id;
            $regist->student_seating_number = $request->seating_number;
            $regist->save();
            return 'successfully';
         }
        catch (\Exception $e){
            return 'Error';
        }
    }
}
