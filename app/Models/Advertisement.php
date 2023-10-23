<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desc',
        'confirmed',
        'user_id',
        'published_at',
        'ad_level',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
