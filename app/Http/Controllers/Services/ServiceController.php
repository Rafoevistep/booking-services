<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\StoreServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
       $services = Service::all();
       return $this->ResponseJson($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName
        ]);

        // Save Image in Storage folder
        Storage::disk('public')->put($imageName, file_get_contents($request->image));

        return $this->ResponseJson($service);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $service = Service::find($id);

        return $this->ResponseJson($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id): JsonResponse
    {
        $service = Service::find($id);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->image) {
            // Public storage
            $storage = Storage::disk('public');

            // Old image delete
            if ($storage->exists($service->image))
                $storage->delete($service->image);

            // Image name
            $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $service->image = $imageName;

            // Image save in public folder
            $storage->put($imageName, file_get_contents($request->image));

            $service->update(['image' => $imageName ]);
        }

        return $this->ResponseJson($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = Service::destroy($id);

        return $this->ResponseJson(['Service Successfully Deleted', $user]);
    }
}
