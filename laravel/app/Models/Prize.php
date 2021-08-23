<?php

namespace App\Models;

use App\Jobs\ProceedPrizeJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'gift_id',
        'type',
        'status'
    ];

    public function gift(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Gift::class, 'id', 'gift_id');
    }

    public function getMessageAttribute()
    {
        switch ($this->type) {
            case 'money':
                return "Поздравляем! Вы выиграли {$this->amount}$";
            case 'bonus':
                return "Поздравляем! Вы выиграли {$this->amount} бонусов на свой счёт";
            case 'gift':
                $gift = $this->gift;
                return "Поздравляем! Вы выиграли ({$gift->title})";
            default:
                return new \Exception('Неправильный тип приза');
        }
    }

    protected static function booted()
    {
        static::created(function ($prize) {
            ProceedPrizeJob::dispatch($prize)->delay(60);
        });

        static::deleted(function ($prize) {
            $gift = $prize->gift;
            if (!$gift)
                return;
            $gift->count++;
            $gift->save();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *
     */
    public function proceed()
    {
        if ($this->status != 'draft')
            return;

        switch ($this->type) {
            case 'money':
                dump("Отправка {$this->amount}$ на карту пользователя");
                break;
            case 'bonus':
                dump("Зачисление {$this->amount} на баланс пользователя пользователя");
                $this->user()->update([
                    'bonuses' => ($this->user->bonuses ?: 0) + $this->amount
                ]);
                break;
            case 'gift':
                dump("Отправка товара помечается вручную работником");
                break;
        }
    }
}
