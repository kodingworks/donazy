<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateTransactionRequest;
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

    public function createPayment(string $slug, CreateTransactionRequest $request) {
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
            "amount" => $transaction->amount,
            "payer_email" => $transaction->user_email,
            "description" => $campaign->name,
            "invoice_dutation" => Carbon::now()->addHour(1)->toIso8601String(),
        ];

        $payment = \Xendit\Invoice::create($params);
        return $this->respond($payment);
    }catch (\Exception $e) {
        return response()->json($e->getMessage());
    }

    }
}
