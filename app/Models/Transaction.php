<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'date', 'amount', 'type', 'description', 'transaction_number'];
}
