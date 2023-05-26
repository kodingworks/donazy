<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function exceptionError($exception, $status = 400)
    {
        return response()->json([
            'meta' => [
                "success" => false,
                'error' => is_array($exception) ? $exception : $exception
            ]
        ], $status);
    }

    public function messageSuccess($message = "Success", $status = 400)
    {
        return response()->json([
            'meta' => [
                "success" => true,
                'message' => $message
            ]
        ], $status);
    }
    
    public function respond($data)
    {
        return response()->json([
            'data' => $data
        ]);
    }
}
