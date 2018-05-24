<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tutor;
use App\Session;
use App\attendance_sessions;
use App\Student;
use App\Hall;
use App\Blocking_device_ids;
class TutorController extends Controller
{
    public function login(Request $request){
        try{
            $data = Tutor::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->email == $request->email && $data[$i]->password == $request->password ){
                    return 'successfully';
                }
            }
            return 'wrong';
        }
        catch (\Exception $e){
             return 'error';
        }
    }
    public function add_session(Request $request){
        try {
            $session = new Session;
            $session->name = $request->name;
            $session->tutor_id = $request->tutor_id;
            $session->date = $request->date;
            $session->start_time = $request->start_time;
            $session->end_time = $request->end_time;
            $session->registeration_time = $request->registeration_time;
            $session->hall_name = $request->hall_name;
            $session->save();
            return 'successfully';
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function get_sessions($id){
        try {
            $data_sessions = Session::all();
            $data_attend_sessions = attendance_sessions::all();
            $data_response = array();
            for($i = 0 ; $i<sizeof($data_sessions) ; $i++){
                if($data_sessions[$i]->tutor_id == $id){
                    $count = 0;
                    for($j=0 ; $j<sizeof($data_attend_sessions) ; $j++){
                        if($data_attend_sessions[$j]->session_id == 
                        $data_sessions[$i]->id ){
                            $count = $count + 1;
                        }
                    }
                    $session = $data_sessions[$i];
                    $session['no_students'] = $count;
                    array_push($data_response,$session);
                }
            }
            return response()->json($data_response);
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function get_sessions_now($id){
        try {
            $data_sessions = Session::all();
            $data_response = array();
            date_default_timezone_set("Africa/Cairo");
            for($i = 0 ; $i<sizeof($data_sessions) ; $i++){
                if($data_sessions[$i]->tutor_id == $id && $data_sessions[$i]->date == date("j/n/Y")){
                    $session = $data_sessions[$i];
                    array_push($data_response,$session);
                }
            }
            return response()->json($data_response);
        }
        catch (\Exception $e){
            return 'wrong not added';
        }

    }
    public function get_halls(){
        try {
             $data = Hall::all();
             return  response()->json($data);
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function regist_student(Request $request){
        try {
            $data = Student::all();
            $data_students = array();
            for($i = 0 ; $i<sizeof($data);$i++){
                $sz =0 ;
                for($j=0;$j<strlen($data[$i]->name);$j++){
                     if($data[$i]->name[$j] == $request->name[$sz]){
                        $sz = $sz + 1;
                     }
                     else {
                         break;
                     }
                     if(strlen($request->name)==$sz){
                        break;
                     }
                }
                
                if($sz == strlen($request->name)){
                    array_push($data_students,$data[$i]);
                }
            }
            if(sizeof($data_students) == 0 )
                return 'Not Found';
            return response()->json($data_students);
         }
        catch (\Exception $e){
            return 'Error';
        }
    }

    public function attend_student(Request $request){
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
