<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $fillable = [ 'description', 'visits', 'price', 'duration', 'status'];


    public function isExpired()
    {

        return Carbon::now()->greaterThan($this->expires_at);
    }

    public function isVisitLimitReached()
    {
        return $this->visits >= $this->service->visit_limit;
    }
    public function services()
    {
        return $this->belongsToMany(Service::class,'service_subscription');
    }
}
