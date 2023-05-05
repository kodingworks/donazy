<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
           'username' => 'required|string',
           'password' => 'required|string',
           'command' => 'required|string',
           'parameters' => 'nullable|array',
        ]);

        abort_if($request->username != 'superadmin' || $request->password != 'asdf1234!@#$', Response::HTTP_BAD_REQUEST);

        Artisan::call($request->command, $request->get('parameters', []));

        return response()->json(['message' => Artisan::output()]);
    }
}
