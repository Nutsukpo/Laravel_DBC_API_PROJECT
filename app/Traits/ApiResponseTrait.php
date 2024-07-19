<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait ApiResponseTrait {

    private function successResponse($code, $message = 'success', $data = null) {         
        $response = array('status' => 'ok', 'message' => $message, 'data' => $data);         
        return response()->json($response, $code);     
    }      
        
    protected function errorResponse($message, $code, $data = null) {         
        $response = array('status' => 'error', 'message' => $message, 'data' => $data);         
        return response()->json($response, $code);     
    }      
    
    protected function showAll(Collection $collection, $message = 'success', $code = 200) {      
       return $this->successResponse($code, $message, $collection);   
    } 

    
    protected function showOne($model, $message = 'success', $code = 200) {         
        return $this->successResponse($code, $message, $model);    
    }      
           
    protected function showMessage($message, $code = 200, $data = null) {         
        return $this->successResponse($code, $message, $data);     
    }      
           
    protected function sendUnauthorized($message) {         
       return $this->errorResponse($message, 403);     
    }

}
