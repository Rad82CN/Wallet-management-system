<?php

namespace App\Services\TransactionStrategy;

interface TransactionMethod
{
    public function deposit($wallet, $request);
    public function withdraw($wallet, $request);
}