<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Tutor;
use App\Student;
use App\Hall;
class AdminController extends Controller
{
    public function login(Request $request){
        try{
            $data = Admin::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->email == $request->email && $data[$i]->password == $request->password ){
                    return 'successfully';   
                }
            }
            return 'Not Found';
        }
        catch (\Exception $e){
             return 'wrong';
        }
    }
    public function add_admin(Request $request){
        try {
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = $request->password;
            $admin->save();
            return 'successfully';
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function add_tutor(Request $request){
        try {
            $tutor = new Tutor;
            $tutor->name = $request->name;
            $tutor->email = $request->email;
            $tutor->password = $request->password;
            $tutor->save();
            return 'successfully';
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function add_student(Request $request){
        try {
            return 'successfully';            
            $student = new Student;
            $student->name = $request->name;
            $student->address = $request->address;
            $student->department = $request->department;
            $student->level = (int)$request->level;
            $student->device_id = 'empty';
            $student->national_id = $request->national_id;
            $student->seating_number = (int)$request->seating_number;
            $student->save();
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function add_hall(Request $request){
        try {
            $hall = new Hall;
            $hall->name = $request->name;
            $hall->type = $request->type;
            $hall->longitude =(double)$request->longitude;
            $hall->latitude = (double)$request->latitude;
            $hall->save();
            return 'successfully';
        }
        catch (\Exception $e){
            return 'wrong not added';
        }
    }
    public function get_tutors(){
        try {
            $data = Tutor::all();
            if(sizeof($data) == 0){
                return 'No Data found';
            }
            return response()->json($data);
        }
        catch (\Exception $e){
            return 'No data';
        }
    }
    public function get_students(){
        try {
            $data = Student::all();
            if(sizeof($data) == 0){
                return 'No Data found';
            }
            return response()->json($data);
        }
        catch (\Exception $e){
            return 'No data';
        }
    }
    public function update_student(Request $request){
        try {
            $data = Student::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->id == $request->id){
                    $data[$i]->national_id = $request->national_id;
                    $data[$i]->seating_number = (int)$request->seating_number;
                    $data[$i]->save();
                    return 'successfully';   
                }
            }
            return 'Not Found this student';
        } 
        catch (\Exception $e){
            return 'wrong not updated';
        }
    }
    public function update_tutor(Request $request){
        try {
            $data = Tutor::all();
            for($i = 0 ; $i<sizeof($data);$i++){
                if($data[$i]->id == $request->id){
                    $data[$i]->name = $request->name;
                    $data[$i]->email = $request->email;
                    $data[$i]->save();   
                    return 'successfully';   
                }
            }
            return 'Not Found this tutor';
        } 
        catch (\Exception $e){
            return 'wrong not updated';
        }
    }
    
}
