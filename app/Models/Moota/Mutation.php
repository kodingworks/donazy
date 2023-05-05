<?php

namespace App\Models\Moota;

use App\Models\Mutation as ModelMutation;
use Illuminate\Support\Carbon;

class Mutation
{
    /*
        Payload example
        [
            {
                "account_number": "7562626004",
                "date": "2021-07-28 20:31:18",
                "description": "Ibnu Akhir Hidayat",
                "note": "",
                "amount": 1570,
                "type": "CR",
                "balance": 593094766.04,
                "updated_at": "2021-07-28 20:31:18",
                "created_at": "2021-07-28 20:31:18",
                "mutation_id": "G1ka3lYEbjg",
                "token": "G1ka3lYEbjg",
                "bank_id": "DZ4jAO8rkAo",
                "bank": {
                    "corporate_id": null,
                    "username": "15395516-10",
                    "atas_nama": "Yayasan Cahaya Sunnah (SIP)",
                    "balance": "629660326.04",
                    "account_number": "7562626004",
                    "bank_type": "bsi",
                    "login_retry": 0,
                    "date_from": "2021-07-28 00:00:00",
                    "date_to": "2021-07-28 00:00:00",
                    "meta": {
                        "browser_session_id": "d516a39f00cd619324793ba2211eae23b5cffeae5b7f8699f35428304a24566c"
                    },
                    "interval_refresh": 15,
                    "next_queue": "2021-07-28 20:46:18",
                    "is_active": true,
                    "in_queue": 0,
                    "in_progress": 0,
                    "recurred_at": "2021-07-29 20:26:24",
                    "created_at": "2021-07-28 20:26:24",
                    "token": "DZ4jAO8rkAo",
                    "bank_id": "DZ4jAO8rkAo",
                    "label": "BSI",
                    "last_update": "2021-07-28T13:31:18.000000Z"
                }
            }
        ]
    */

    /** @var string */
    public $accountNumber;

    /** @var Carbon */
    public $date;

    /** @var string */
    public $description;

    /** @var string */
    public $note;

    /** @var int */
    public $amount;

    /** @var string */
    public $type;

    /** @var int */
    public $balance;

    /** @var Carbon */
    public $updatedAt;

    /** @var Carbon */
    public $createdAt;

    /** @var string */
    public $mutationId;

    /** @var string */
    public $token;

    /** @var string */
    public $bankId;

    /** @var Bank */
    public $bank;

    public function __construct(
        $accountNumber,
        $date,
        $description,
        $note,
        $amount,
        $type,
        $balance,
        $updatedAt,
        $createdAt,
        $mutationId,
        $token,
        $bankId,
        $bank
    ) {
        $this->accountNumber = $accountNumber;
        $this->date = $date;
        $this->description = $description;
        $this->note = $note;
        $this->amount = $amount;
        $this->type = $type;
        $this->balance = $balance;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
        $this->mutationId = $mutationId;
        $this->token = $token;
        $this->bankId = $bankId;
        $this->bank = $bank;
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
