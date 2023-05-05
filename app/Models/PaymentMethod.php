<?php

namespace App\Models;

class PaymentMethod
{
    public int $id;

    public string $icon;

    public string $name;

    public string $account_number;

    public string $account_holder_name;

    public string $type;

    public function __construct(
        int $id,
        string $icon,
        string $name,
        string $account_number,
        string $account_holder_name,
        string $type
    ) {
        $this->id = $id;
        $this->icon = $icon;
        $this->name = $name;
        $this->account_number = $account_number;
        $this->account_holder_name = $account_holder_name;
        $this->type = $type;
    }
}
