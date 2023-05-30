<?php

namespace App\Services;

use App\Models\PaymentMethod;

class PaymentMethodService
{
    public function getPaymentMethod()
    {
        $query = PaymentMethod::get();
        
        return $query;
    }
}
