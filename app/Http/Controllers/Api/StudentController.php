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

    // public function store(Request $request){

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'requird|string|max:191',
    //         'course' => 'requird|string|max:191',
    //         'email' => 'requird|email|max:191',
    //         'phone' => 'requird'
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'status' => 422,
    //             // 'errors' => "$validator->messages()"
    //             'errors' => "validator fails"
    //         ], 422); 
    //     }
    //     else{
           
    //         $student = Student::create([
    //             'name' => $request->name,
    //             'course' => $request->course,
    //             'email' => $request->email,
    //             'phone' => $request->phone
    //         ]);
            

    //         //check if student is successfullyt added or not
    //         if($student){
    //             return response()->json([
    //                 'status' => 200,
    //                 'message'=> 'Student created successfully' ], 200);
    //         }
    //         else{
    //             return response()->json([
    //                 'status' => 500,
    //                 'message'=> 'Something went Wrong' ], 500);
    //         }
    //     }
    // }

    public function store(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'requird',
            'course' => 'requird',
            'email' => 'requird',
            'phone' => 'required'   
        ]);

        // if($validator->fails()){
        //    return response()->json([
        //          'status' => 422,
        //          'errors' => $validator->messages()
        //          ], 422); 
        //      }

        $student = new Student();
        $student->name = request('name');
        $student->course = request('course');
        $student->email = request('email');
        $student->phone = request('phone');
        $student->save();

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
