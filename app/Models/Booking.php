<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'name', 'address', 'phone', 'date', 'total_price', 'status','booking_time','available'];
    Protected $appends = ['available'];
    public function user()
{
    return $this->belongsTo(AppUsers::class);
}

public function service()
{
    return $this->belongsTo(Service::class);
}

public function getAvailableAttribute()
{
    $currentTime = Carbon::now();
    dd($currentTime);
    $bookings = Booking::all();
    foreach ($bookings as $booking) {
        $timeDifference = $currentTime->diffInHours($booking->booking_time);
        dd( $timeDifference);
        $timeDifference >= $booking->service->duration??2 ? 1 : 0;

        $booking->available = $timeDifference ;
        $booking->save();
    }


}
public function setAvailableAttribute()
{
    $currentTime = Carbon::now();
    $timeDifference = $currentTime->diffInHours($this->booking_time);

    return $this->available = $timeDifference >= $this->service->duration ? 1 : 0;



}
}
