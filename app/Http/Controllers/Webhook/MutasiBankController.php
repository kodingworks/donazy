<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Jobs\SaveMutasiBankMutation;
use App\Services\MutasiBankService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class MutasiBankController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_key' => 'required|string',
        ]);

        abort_if($request->get('api_key') != Config::get('services.mutasibank.apikey'), Response::HTTP_BAD_REQUEST);

        $mutasiBankService = new MutasiBankService($request->all());

        SaveMutasiBankMutation::dispatch($mutasiBankService);

        return response()->json([]);
    }
}
