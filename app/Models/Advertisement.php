<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'business_categories',
        'desc',
        'confirmed',
        'user_id',
        'published_at',
        'ad_level',
        'hits',
        'rating',
        'city',
        'iran_city_id',
        'province',
        'iran_province_id',
    ];

    // @todo: use model attributes casting for cleaner source code XD
    protected $casts = [
//        'business_images' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getCity()
    {
        return $this->belongsTo(IranCity::class, 'iran_city_id');
    }

    public function getProvince()
    {
        return $this->belongsTo(IranProvince::class, 'iran_province_id');
    }

    public function getCategories()
    {
        return $this->getCategory();
    }

    public function getCategory() {
        $c = json_decode($this->business_categories);
        return Occupation::find($c)->name;
    }

    public function getSlug()
    {
        return str_replace([' ', '.', '،'], '-', $this->business_name);
    }

    public function getRatings() {
        return json_decode($this->rating);
    }

    public function Transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
