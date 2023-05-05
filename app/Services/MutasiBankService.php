<?php

namespace App\Services;

use App\Models\MutasiBank\Account as MutasiBankAccount;
use App\Models\MutasiBank\Mutation as MutasiBankMutation;
use App\Models\Mutation;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MutasiBankService
{
    /*
        Response Example
        {
            "api_key":"UmRTOGQ1ckU3QUY4c3VidnBCaFYxbzI4djR5MEo2YVFud3B2NTNrUkpZRjFCSG76e115db7cdVZT3Z6MU51YmZhMnAy5b",
            "account_id": 12,
            "module": "bri",
            "account_name": "PT Amanah Karya Indonesia",
            "account_number": null,
            "balance": 429090,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": 30097,
                "balance": 427099
            }, {
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  JONI            TO PT AMANAH KARYA",
                "type": "DB",
                "amount": 20002,
                "balance": 429099
            }]
        }
    */

    /** @var array $payload */
    protected array $payload;

    /** @var MutasiBankAccount $account */
    protected MutasiBankAccount $account;

    /** @var Collection<MutasiBankMutation> $mutattions */
    protected Collection $mutations;

    public function __construct(array $payload)
    {
        $this->payload = $payload;

        $this->mutations = collect($payload['data_mutasi'])
            ->map(function (array $mutation) {
                return new MutasiBankMutation(
                    $mutation['transaction_date'],
                    $mutation['description'],
                    $mutation['type'],
                    $mutation['amount'],
                    $mutation['balance']
                );
            });

        $this->account = new MutasiBankAccount(
            $payload['api_key'],
            $payload['account_id'],
            $payload['module'],
            $payload['account_name'],
            $payload['account_number'],
            $payload['balance'],
            $this->mutations
        );
    }

    public function save(): void
    {
        DB::beginTransaction();

        $this
            ->mutations
            ->each(function (MutasiBankMutation $mutation) {
                Mutation::firstOrCreate([
                    'account_number' => $this->account->accountNumber,
                    'account_holder_name' => $this->account->accountName,
                    'bank_name' => Str::upper($this->account->module),
                    'received_at' => $mutation->transactionDate,
                    'type' => $mutation->getFormattedType(),
                    'balance' => $mutation->balance,
                    'amount' => $mutation->amount,
                    'description' => $mutation->description,
                ]);

                if ($mutation->getFormattedType() == Mutation::TYPE_CREDIT) {
                    $transaction = Transaction::query()
                        ->where('status', Transaction::STATUS_WAITING)
                        ->where('total', $mutation->amount)
                        ->first();

                    if ($transaction) {
                        $transaction->update(['status' => Transaction::STATUS_PAID]);
                    }
                }
            });

        DB::commit();
    }
}
