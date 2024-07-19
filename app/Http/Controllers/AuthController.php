<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'contact' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        User::create($request->toArray());

        return $this->showMessage("Registration success", 201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)){
            return $this->errorResponse('Invalid Credentials', 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken($user->name)->plainTextToken;

        return $this->showMessage("Login Successful", 200, $token);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return $this->showMessage("Logout Successful");
    }

    public function users() {
        $users = User::all();

        return $this->showAll($users);
    }

    public function user($id) {
        $user = User::find($id);

        if(!$user){
            return $this->errorResponse('User not Found', 404);
        }

        return $this->showOne($user);
    }

    public function update(Request $request, $id) {
        //save the request to a variable called data
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required | min:2',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $user = User::find($id);

        if ($user) {
            $user->name = $data['name'];
            $user->save();

            return $this->showMessage("Update Successful", 200, $user);
        }

        return $this->errorResponse("User not Found", 404);
    }

    public function delete($id){
        $user = User::find($id);
        
        if(!$user){
            return $this->errorResponse('User not Found', 404);
        }
        
        $user->delete();

        return $this->showMessage("User Deleted Successful");
    }

    public function restore($id){
        $user = User::withTrashed()->find($id);
        
        if(!$user){
            return $this->errorResponse('User not Found', 404);
        }
        
        $user->restore();

        return $this->showMessage("User Restored Successful");
    }
}
