<?php

namespace Theamostafa\Wallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Str;

/**
 * Class Transaction.
 *
 * @property string $payable_type
 * @property int|string $payable_id
 * @property int $wallet_id
 * @property string $uuid
 * @property string $type
 * @property string $amount
 * @property int $amountInt
 * @property string $amountFloat
 * @property bool $confirmed
 * @property array $meta
 * @property Wallet $payable
 * @property Wallet $wallet
 *
 * @method int getKey()
 */
class Transaction extends Model {
    use HasFactory;

    protected string $table = 'wallet_transactions';
    protected $guarded = ['id'];
    public const TYPE_DEPOSIT = 'deposit';
    public const TYPE_WITHDRAW = 'withdraw';
    protected $casts = [
        'wallet_id' => 'int',
        'confirmed' => 'bool',
        'meta' => 'json',
    ];

    protected static function booted() {
        parent::booted();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function payable(): MorphTo {
        return $this->morphTo();
    }

    public function wallet(): BelongsTo {
        return $this->belongsTo(Wallet::class);
    }

    public function getAmountIntAttribute(): int {
        return (int)$this->amount;
    }

    public function getDescriptionAttribute(): string {
        return $this->meta['description'] ?? '';
    }

    public function getAmountFloatAttribute(): string {
        return (float)$this->amount;
    }
}
