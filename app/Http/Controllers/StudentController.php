<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    use ApiResponseTrait;

    //function to store data into the db
    public function registerstudent(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'firstname' => 'required | min:2',
            'lastname' => 'required | min:2',
            'student_id' => 'required',
            'email' => 'required | email | unique:students,email',
            'course_name' => 'required',
            'contact' => 'required | min:10 | max:13 | unique:students,contact',
            'address' => 'required ',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        Student::create($request->toArray());

        return $this->showMessage("Student Registration Successful", 201);
    }

    //function to get students
    public function students()
    {
        $students = Student::all();
        return $this->showAll($students);
    }

    //function to get one student
    public function student($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->errorResponse('Student not Found', 404);
        }
        return $this->showOne($student);
    }

    // function to update student
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'firstname' => 'required | min:2',
            'lastname' => 'required | min:2',
            'student_id' => 'required',
            'email' => 'required | email | email',
            'course_name' => 'required',
            'contact' => 'required | min:10 | max:13 ',
            'address' => 'required ',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }
        $student = Student::find($id);
        if ($student) {
            $student->firstname = $data['firstname'];
            $student->lastname = $data['lastname'];
            $student->student_id = $data['student_id'];
            $student->email = $data['email'];
            $student->course_name = $data['course_name'];
            $student->contact = $data['contact'];
            $student->address = $data['address'];
            $student->save();

            return $this->showMessage("Update Successful", 200, $student);
        }
    }
    //function to delete student
    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->errorResponse('Student not found', 400);
        }

        $student->delete();
        return $this->showMessage("Student Deleted Successful");
    }

    //function to retore deleted student
    public function restore($id)
    {
        $student = Student::withTrashed()->find($id);

        if (!$student) {
            return $this->errorResponse('Student not Found', 404);
        }

        $student->restore();

        return $this->showMessage("Student Restored Successful");
    }
}
