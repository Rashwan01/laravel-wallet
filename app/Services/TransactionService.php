<?php

namespace Theamostafa\Wallet\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Theamostafa\Wallet\Exceptions\InsufficientFunds;
use Theamostafa\Wallet\Exceptions\InvalidAmount;
use Theamostafa\Wallet\Models\Transaction;
use Theamostafa\Wallet\Models\Wallet;

class TransactionService {
    static public function deposit(Wallet $wallet, int|float $amount, array $meta, bool $confirmed): Model {
        return (new static())->create(Transaction::TYPE_DEPOSIT, $wallet, $amount, $meta, $confirmed);
    }

    static public function withdraw(Wallet $wallet, int|float $amount, array $meta, bool $confirmed): Model {
        return (new static())->create(Transaction::TYPE_WITHDRAW, $wallet, $amount, $meta, $confirmed);
    }

    public function create($type, Wallet $wallet, int|float $amount, array $meta, bool $confirmed): Model {
        if ($amount <= 0) {
            throw new InvalidAmount;
        }
        if ($type == Transaction::TYPE_WITHDRAW && $wallet->balance < $amount) {
            throw new InsufficientFunds("InsufficientFunds, Account Balance $wallet->balance and you try to withdraw $amount");
        }

        if (!$wallet->balance) {
            throw new InsufficientFunds;
        }
        $transaction = $wallet->transactions()->create([
            'type' => $type,
            'payable_type' => $wallet->holder::class,
            'payable_id' => $wallet->holder->id,
            'amount' => $amount,
            'meta' => $meta,
            'confirmed' => $confirmed
        ]);
        $wallet->update([
            'balance' => $wallet->transactions()->select(
                DB::raw(
                    "CASE WHEN type = 'deposit' THEN amount ELSE CAST(-amount AS float) END as balance"
                ))->get()->sum('balance')
        ]);
        return $transaction;
    }
}
