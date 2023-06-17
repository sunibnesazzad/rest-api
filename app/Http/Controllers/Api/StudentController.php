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

            return response(['error' => $validator->errors(), '422'=> 'Validation Error']);
        
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
    
    //showing student id
    public function show($id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message'=> 'No Such Student Found' ], 404);
        }

    }

    //Editing student detail
    public function edit($id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message'=> 'No Such Student Found' ], 404);
        }

    }

    //Updating student detail
    public function update(Request $request, int $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11'
        ]);

        

        if($validator->fails()){

            return response(['error' => $validator->errors(), '422'=> 'Validation Error']);
        
        }
        else{
           
            $student = Student::find($id);

            if($student){
                $student -> update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);
                if($student){
                    return response()->json([
                        'status' => 200,
                        'message'=> 'Student Updated successfully' ], 200);
                }
                else{
                    return response()->json([
                        'status' => 500,
                        'message'=> 'Something went Wrong' ], 500);
                }
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message'=> 'No Such Student Found' ], 404);
            }
            
            
        }

    }

    //Deleting Student ID
    public function destroy($id){

        $student = Student::find($id);

        if($student){
            //deleting student ID
            $student->delete();

            return response()->json([
                'status' => 200,
                'message'=> 'Student Data Deleted successfully' ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message'=> 'No Such Student Found' ], 404);
        }
    }
        
}
