<?php

namespace Theamostafa\Wallet\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Theamostafa\Wallet\Models\Transaction;
use Theamostafa\Wallet\Models\Wallet;
use Theamostafa\Wallet\Services\TransactionService;

trait HasWallet {
    protected static function bootHasWallet() {
        static::retrieved(function ($model) {
            if (!$model->wallet()->exists()) {
                $model->wallet()->create(['balance' => 0, 'name' => 'Default Wallet']);
            }
        });
    }

    public function deposit(int|float $amount, ?array $meta = [], bool $confirmed = true) {
        return TransactionService::deposit($this->wallet, $amount, $meta, $confirmed);
    }

    public function withdraw(int|float $amount, ?array $meta = [], bool $confirmed = true) {
        return TransactionService::withdraw($this->wallet, $amount, $meta, $confirmed);

    }

    public function wallet() {
        return $this->morphOne(Wallet::class, 'holder');
    }

    public function getBalanceAttribute(): string {
        return $this->wallet->balance;
    }

    public function getBalanceIntAttribute(): int {
        return (int)$this->getBalanceAttribute();
    }
    public function getBalanceFloatAttribute(): float {
        return (float)$this->getBalanceAttribute();
    }

    /**
     * We receive transactions of the selected wallet.
     */
    public function walletTransactions(): HasMany {
        return $this->hasMany(Transaction::class, 'wallet_id');
    }

    /**
     * all user actions on wallets will be in this method.
     */
    public function transactions(): MorphMany {
        return $this->morphMany(Transaction::class, 'payable');
    }

}
