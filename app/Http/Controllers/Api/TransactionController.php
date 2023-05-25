<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionStatusUpdateRequest;
use App\Http\Requests\Api\CreateTransactionRequest;
use App\Http\Requests\CampaignTransactionStoreRequest;
use App\Models\Campaign;
use App\Models\Transaction;
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
            $data = [
                "invoice_url" => $payment["invoice_url"],
                "expiry_date" => $payment["expiry_date"],
                "status" => $payment["status"],
                "amount" => $payment["amount"],
                "description" => $payment["description"],
                "external_id" => $payment["external_id"],
            ];       
            
            return $this->respond($data);
        }catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }

    public function callback(TransactionStatusUpdateRequest $request) {
        try{
            $data = $request->all();
            $transaction = Transaction::where('code', $data['external_id'])->first();
            $transaction->update($request->validated());
            return response()->json($data);
        }catch (\Exception $e) {
            return response()->json([
                'message' => "external_id not found",
            ]);
        }
    }
}
