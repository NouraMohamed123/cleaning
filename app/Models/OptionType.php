<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function options()
    {
        return $this->hasMany(Options::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_option_type');
    }
}
