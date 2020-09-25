<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'details', 'amount'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'from', 'id');
    }
}
