<?php

use App\Services\TransactionStrategy\Cbc;
use App\Services\TransactionStrategy\Sheba;

class TransactionFactory 
{
    public function create(string $type) {
        return match($type) {
            'cbc' => resolve(Cbc::class),
            'sh' => resolve(Sheba::class),
        };
    }
}