<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function user()
{
    return $this->belongsTo(AppUsers::class);
}

public function service()
{
    return $this->belongsTo(Service::class);
}


}
