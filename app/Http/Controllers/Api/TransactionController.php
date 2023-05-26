<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionStatusUpdateRequest;
use App\Http\Requests\Api\CreateTransactionRequest;
use App\Models\Campaign;
use App\Models\TransactionApi;
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
            ->transactionsApi()
            ->create($request->validation());

            $transactionCodes = [];


            $transactionCodes[] = $transaction->code;


            $params = [
                "external_id" => $transaction->code,
                "amount" => $transaction->amount,
                "payer_email" => $transaction->user_email,
                "description" => $campaign->name,
                "invoice_duration" => 3600,
            ];

            $payment = \Xendit\Invoice::create($params);
            $data = [
                "payment_url" => $payment["invoice_url"],
                "expiry_date" => $payment["expiry_date"],
                "status" => $payment["status"],
                "amount" => $payment["amount"],
                "description" => $payment["description"],
                "invoice_id" => $payment["external_id"],
            ];       
            
            return $this->respond($data);
        }catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }

    public function callback(TransactionStatusUpdateRequest $request) {
        try{
            $data = $request->all();
            $transaction = TransactionApi::where('code', $data['external_id'])->first();
            if($data['status'] == 'PAID') {
                $transaction->update([
                    'status' => TransactionApi::STATUS_PAID,
                ]);
            }else if($data['status'] == 'EXPIRED') {
                $transaction->update([
                    'status' => TransactionApi::STATUS_EXPIRED,
                ]);
            }
            $transaction->update($request->validated());
            return response()->json([
                'message' => "success",
               'status' => $transaction->status,
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'message' => "external_id not found",
            ]);
        }
    }

    public function getTransaction($invoice_id) {
        try{
            $transaction = TransactionApi::where('code', $invoice_id)->first();
            return $this->respond([
                'message' => "success get transaction status",
                'status' => $transaction->status,
            ]);
           
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
