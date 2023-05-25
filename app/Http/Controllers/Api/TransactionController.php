<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Xendit;

class TransactionController extends Controller
{
    private $payement;
    public function __construct()
    {
        Xendit::setApiKey('xnd_development_...');
    }
}
