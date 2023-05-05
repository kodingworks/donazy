<?php

namespace App\Models\Moota;

use Illuminate\Support\Carbon;

class Bank
{
    /*
        Payload example
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
        },
    */

    /** @var string|null */
    public $corporateId;

    /** @var string */
    public $username;

    /** @var string */
    public $atasNama;

    /** @var int */
    public $balance;

    /** @var string */
    public $accountNumber;

    /** @var string */
    public $bankType;

    /** @var int */
    public $loginRetry;

    /** @var Carbon */
    public $dateFrom;

    /** @var Carbon */
    public $dateTo;

    /** @var int */
    public $intervalRefresh;

    /** @var Carbon */
    public $nextQueue;

    /** @var bool */
    public $isActive;

    /** @var int */
    public $inQueue;

    /** @var int */
    public $inProgress;

    /** @var Carbon */
    public $recurredAt;

    /** @var Carbon */
    public $createdAt;

    /** @var string */
    public $token;

    /** @var string */
    public $bankId;

    /** @var string */
    public $label;

    /** @var Carbon */
    public $lastUpdate;

    public function __construct(
        $corporateId,
        $username,
        $atasNama,
        $balance,
        $accountNumber,
        $bankType,
        $loginRetry,
        $dateFrom,
        $dateTo,
        $intervalRefresh,
        $nextQueue,
        $isActive,
        $inQueue,
        $inProgress,
        $recurredAt,
        $createdAt,
        $token,
        $bankId,
        $label,
        $lastUpdate
    ) {
        $this->corporateId = $corporateId;
        $this->username = $username;
        $this->atasNama = $atasNama;
        $this->balance = $balance;
        $this->accountNumber = $accountNumber;
        $this->bankType = $bankType;
        $this->loginRetry = $loginRetry;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->intervalRefresh = $intervalRefresh;
        $this->nextQueue = $nextQueue;
        $this->isActive = $isActive;
        $this->inQueue = $inQueue;
        $this->inProgress = $inProgress;
        $this->recurredAt = $recurredAt;
        $this->createdAt = $createdAt;
        $this->token = $token;
        $this->bankId = $bankId;
        $this->label = $label;
        $this->lastUpdate = $lastUpdate;
    }
}
