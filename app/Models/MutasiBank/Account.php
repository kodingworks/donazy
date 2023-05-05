<?php

namespace App\Models\MutasiBank;

use Illuminate\Support\Collection;

class Account
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

    /** @var string $apiKey */
    public string $apiKey;

    /** @var string $accountId */
    public string $accountId;

    /** @var string $module */
    public string $module;

    /** @var string $accountName */
    public string $accountName;

    /** @var string|null $accountNumber */
    public $accountNumber;

    /** @var int $balance */
    public int $balance;

    /** @var Collection<Mutation> $mutations */
    public Collection $mutations;

    public function __construct(
        string $apiKey,
        string $accountId,
        string $module,
        string $accountName,
        $accountNumber,
        string $balance,
        Collection $mutations
    ) {
        $this->apiKey = $apiKey;
        $this->accountId = $accountId;
        $this->module = $module;
        $this->accountName = $accountName;
        $this->accountNumber = $accountNumber;
        $this->balance = intval($balance);
        $this->mutations = $mutations;
    }
}
