<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Jobs\SaveMootaMutation;
use App\Services\MootaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MootaController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /** @var MootaService */
        $mootaService = new MootaService($request->getContent());

        abort_if(!$mootaService->validateSignature($request->header('signature')), Response::HTTP_UNAUTHORIZED);

        SaveMootaMutation::dispatch($mootaService);

        return response()->json(['status' => Response::HTTP_OK]);
    }
}
