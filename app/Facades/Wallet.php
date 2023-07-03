<?php

namespace Theamostafa\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Theamostafa\Wallet\Wallet
 */
class Wallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Theamostafa\Wallet\Wallet::class;
    }
}
