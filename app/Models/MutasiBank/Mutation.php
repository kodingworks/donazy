<?php

namespace App\Models\MutasiBank;

use Illuminate\Support\Carbon;
use App\Models\Mutation as ModelMutation;

class Mutation
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

    /** @var Carbon $transactionDate */
    public Carbon $transactionDate;

    /** @var string $description */
    public string $description;

    /** @var string $type */
    public string $type;

    /** @var int $amount */
    public string $amount;

    /** @var int $balance */
    public string $balance;

    public function __construct(
        string $transactionDate,
        string $description,
        string $type,
        string $amount,
        string $balance
    ) {
        $this->transactionDate = Carbon::parse($transactionDate);
        $this->description = $description;
        $this->type = $type;
        $this->amount = intval($amount);
        $this->balance = intval($balance);
    }

    public function getFormattedType(): string
    {
        switch ($this->type) {
            case 'CR':
                return ModelMutation::TYPE_CREDIT;
            case 'DB':
                return ModelMutation::TYPE_DEBIT;
        }
    }
}
