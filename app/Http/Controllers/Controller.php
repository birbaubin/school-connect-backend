<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function sendResult($data, $code)
    {
        return response()->json(['success'=>true, 'data'=>$data], $code);
    }

    public function sendConfirmation($message, $code)
    {
        return response()->json(['success'=>true, 'message'=>$message], $code);
    }  

    public function sendError($message, $code)
    {
        return response()->json(['success'=>false, 'message'=>$message], $code);
    }

}
