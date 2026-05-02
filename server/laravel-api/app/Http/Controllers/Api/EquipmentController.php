<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;

class EquipmentController extends Controller
{
    public function index(): JsonResponse
    {
        $equipments = Equipment::query()->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Equipment list fetched',
            'data' => EquipmentResource::collection($equipments),
            'meta' => [
                'current_page' => $equipments->currentPage(),
                'last_page' => $equipments->lastPage(),
                'per_page' => $equipments->perPage(),
                'total' => $equipments->total(),
            ],
        ]);
    }

    public function store(StoreEquipmentRequest $request): JsonResponse
    {
        $equipment = Equipment::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Equipment created',
            'data' => new EquipmentResource($equipment),
        ], 201);
    }

    public function show(Equipment $equipment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Equipment fetched',
            'data' => new EquipmentResource($equipment),
        ]);
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $equipment->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Equipment updated',
            'data' => new EquipmentResource($equipment->fresh()),
        ]);
    }

    public function destroy(Equipment $equipment): JsonResponse
    {
        // Soft deletes can be introduced later; hard delete is used for MVP.
        $equipment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Equipment deleted',
            'data' => null,
        ]);
    }
}
