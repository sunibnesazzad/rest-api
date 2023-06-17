<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){

        $students = Student::all();

        $data = [
            'status' => 200,
            'students' => $students
        ];
        
        if($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students], 200);
        }
        else {
            return response()->json([
                'status' => 404,
                'message'=> 'Students data not found' ], 404);
        }
       
    }

    //Storing student data in database

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11'
        ]);

        

        if($validator->fails()){

            return response(['error' => $validator->errors(), 'Validation Error']);
        
        }
        else{
           
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            

            //check if student is successfullyt added or not
            if($student){
                return response()->json([
                    'status' => 200,
                    'message'=> 'Student created successfully' ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message'=> 'Something went Wrong' ], 500);
            }
        }
    }

   
        
}
