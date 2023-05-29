<?php

namespace App\Http\Controllers;

use App\Services\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $paymentMethodService;
    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function getPaymentMethod() {
        $query = $this->paymentMethodService->getPaymentMethod();
        return response()->json([
            'status' => 'success',
            'data' => $query
        ]);
    }
}
