<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'paid',
        'transaction_info',
        'transaction_ref_id',
    ];

    public function Advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function Package()
    {
        return $this->belongsTo(Package::class);
    }
}
