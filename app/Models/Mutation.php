<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const TYPE_CREDIT = 'CREDIT';

    public const TYPE_DEBIT = 'DEBIT';

    public const TYPES = [
        self::TYPE_CREDIT,
        self::TYPE_DEBIT,
    ];
}
