<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyConvert extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'value', 'created_at', 'updated_at'];
}
