<?php

namespace App\Http\Requests\Booking;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email:dns',
            'customer_phone' => 'required|string',
            'booking_date' => 'date_format:Y-m-d|after:'.Carbon::now()->subDay()->format('Y-m-d'),
            'booking_start_time' => 'after:' . Carbon::now()->timezone('Asia/Yerevan'),
            'booking_end_time' => 'date_format:H:i:s|after:booking_start_time'
        ];
    }
}
