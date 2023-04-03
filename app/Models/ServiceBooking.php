<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'booking_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'booking_date',
        'booking_start_time',
        'booking_end_time',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class , 'service_id');
    }

}
