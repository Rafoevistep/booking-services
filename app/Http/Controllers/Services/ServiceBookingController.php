<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateRequest;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Services\Admin\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $bookedServices = ServiceBooking::all();
        return $this->ResponseJson($bookedServices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, string $id, BookingService $bookingService): JsonResponse
    {
        $service = Service::find($id);

        $service_id = $service['id'];

        $data = (object)$request->all();

        $overlappingBookingsQuery = ServiceBooking::where('service_id', $service_id)
            ->where('booking_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereBetween('booking_start_time', [$request->booking_start_time, $request->booking_end_time])
                        ->orWhereBetween('booking_end_time', [$request->booking_start_time, $request->booking_end_time]);
                })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('booking_start_time', '<', $request->booking_start_time)
                            ->where('booking_end_time', '>', $request->booking_start_time);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('booking_start_time', '<', $request->booking_end_time)
                            ->where('booking_end_time', '>', $request->booking_end_time);
                    });
            })->first();

        if ($overlappingBookingsQuery) return $this->ErrorResponseJson('Service is Booked');

        $booking = $bookingService->createBooking($data, $service_id);

        return $this->ResponseJson($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $bookingService = ServiceBooking::find($id);

        return $this->ResponseJson($bookingService);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        ServiceBooking::destroy($id);

        return $this->ResponseJson('Service Successfully Deleted');
    }

    /**
     * Search book by booking_number uuid.
     */

    public function search($booking): JsonResponse
    {
        $result = ServiceBooking::where('booking_number', 'LIKE', '%' . $booking . '%')->get();

        if (count($result)) {
            return $this->ResponseJson($result);
        } else {
            return $this->ErrorResponseJson('No Data not found');
        }
    }
}
