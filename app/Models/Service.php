<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'photo','status','duration','is_square_meters'];


    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class,'service_subscription');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    public function optionTypes()
    {
        return $this->hasMany(OptionType::class);
    }
}

