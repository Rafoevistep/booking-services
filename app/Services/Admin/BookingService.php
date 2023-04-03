<?php

namespace App\Services\Admin;


use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Support\Str;

class BookingService
{
    public function createBooking($data, $service_id)
    {

        $bookingNumber = Str::uuid();

        $booking = ServiceBooking::create([
            'service_id' => $service_id,
            'booking_number' => $bookingNumber,
            'customer_name' => $data->customer_name,
            'customer_email' => $data->customer_email,
            'customer_phone' => $data->customer_phone,
            'booking_date' => $data->booking_date,
            'booking_start_time' => $data->booking_start_time,
            'booking_end_time' => $data->booking_end_time,
            'customer_address' => $data->customer_address
        ]);

        return $booking;
    }
}
