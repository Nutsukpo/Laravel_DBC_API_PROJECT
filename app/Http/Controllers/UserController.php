<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;

    //function to get users
    public function users()
    {
        $user = User::all();
        return $this->showAll($user);
    }

    //function to get one user
    public function user($id)
    {
        $user = User::find($id);

        if (!$user){
            return $this->errorResponse('User not Found', 404);
        }
        return $this->showOne($user);
    }

    public function update (Request $request, $id){
        $data = $request->all();
        $validator = Validator::make($data, ['name' => 'required | min:2']);

        if ($validator->fails()){
            return $this->errorResponse($validator->errors(), 422);
        }
        $user = User::find($id);
        if ($user){
            $user->name = $data['name'];
            $user->save();

            return $this->showMessage("User Update Successful", 200, $user);
        }
    }

        public function delete($id){
            $user = User::find($id);

            if(!$user){
                return $this->errorResponse('User not found', 400);
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
