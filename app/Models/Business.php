<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'phone',
        'business_name',
        'business_category',
        'work_hours',
        'off_days',
        'address',
        'business_number',
        'instagram',
        'telegram',
        'whatsapp',
        'eitaa',
        'other_social_1',
        'other_social_2',
        'business_images',
        'province',
        'city',
        'lat',
        'lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
