<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_WITHDRAW = 'withdraw';
    public const TYPE_DEPOSIT = 'deposit';

    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PENDING = 'pending';

    public const METHOD_CBC = 'cbc';
    public const METHOD_SH = 'sh';


    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'status',
        'method',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
