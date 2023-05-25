<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignTransactionStoreRequest;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Xendit\Xendit;

class TransactionController extends Controller
{
    public function __construct()
    {
        Xendit::setApiKey(env('XENDIT_SECRET_KEY'));
    }

    public function createPayment(string $slug, Request $request): JsonResponse {
    try {
        $campaign = Campaign::query()
        ->where('slug', $slug)
        ->published()
        ->available()
        ->firstOrFail();

        $transaction = $campaign
        ->transactions()
        ->create($request->validation());

        $transactionCodes = [];

 

        $transactionCodes[] = $transaction->code;


        $params = [
            "external_id" => $transaction->code,
            "payer_email" => $transaction->user_email,
            "description" => $campaign->name,
            "amount" => $transaction->amount,
            "invoice_duration" => Carbon::now()->addDay(1)->format('Y-m-d\TH:i:s\Z'),
        ];

        $payment = \Xendit\Invoice::create($params);
        return $this->respond($payment);
    }catch (\Exception $e) {
        return response()->json($e->getMessage());
    }

    }
}
