<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'balance'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toString();
    }

    /**
     * these are transactions initiated by the current user i.e the sender
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function senderTransactions()
    {
        return $this->hasMany(Transaction::class, 'from', 'id');
    }

    /**
     * these are transactions in which the current user is the reciever
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receiverTransactions()
    {
        return $this->hasMany(Transaction::class, 'from', 'id');
    }

    public function transactions()
    {
        return $this->senderTransactions->merge($this->receiverTransactions);
    }

    public function deductAmount($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }

    public function addAmount($amount)
    {
        $this->balance += $amount;
        $this->save();
    }
}
