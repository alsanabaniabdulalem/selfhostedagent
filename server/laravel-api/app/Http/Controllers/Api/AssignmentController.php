<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnAssignmentRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index(): JsonResponse
    {
        $assignments = Assignment::query()
            ->with(['equipment', 'user'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Assignment list fetched',
            'data' => AssignmentResource::collection($assignments),
            'meta' => [
                'current_page' => $assignments->currentPage(),
                'last_page' => $assignments->lastPage(),
                'per_page' => $assignments->perPage(),
                'total' => $assignments->total(),
            ],
        ]);
    }

    public function store(StoreAssignmentRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $equipment = Equipment::query()->findOrFail($payload['equipment_id']);
        if ($equipment->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Equipment is not available for assignment',
                'data' => null,
            ], 422);
        }

        // Transaction guarantees status + assignment row stay consistent.
        try {
            $assignment = DB::transaction(function () use ($payload) {
                $equipment = Equipment::query()->lockForUpdate()->findOrFail($payload['equipment_id']);
                if ($equipment->status !== 'available') {
                    // Race-condition guard if two clients assign simultaneously.
                    throw new \RuntimeException('EQUIPMENT_NOT_AVAILABLE');
                }

                $assignment = Assignment::create($payload);
                $equipment->update(['status' => 'assigned']);

                return $assignment;
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'EQUIPMENT_NOT_AVAILABLE') {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment is not available for assignment',
                    'data' => null,
                ], 422);
            }

            throw $e;
        }

        $assignment->load(['equipment', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Equipment assigned successfully',
            'data' => new AssignmentResource($assignment),
        ], 201);
    }

    public function markReturned(ReturnAssignmentRequest $request, Assignment $assignment): JsonResponse
    {
        $payload = $request->validated();

        if ($assignment->returned_at) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment already marked as returned',
                'data' => null,
            ], 422);
        }

        DB::transaction(function () use ($assignment, $payload) {

            $assignment->update([
                'returned_at' => $payload['returned_at'] ?? now()->toDateString(),
                'notes' => $payload['notes'] ?? $assignment->notes,
            ]);

            // If no active assignment remains for the same equipment, make it available again.
            $activeExists = Assignment::query()
                ->where('equipment_id', $assignment->equipment_id)
                ->whereNull('returned_at')
                ->exists();

            if (!$activeExists) {
                $assignment->equipment()->update(['status' => 'available']);
            }
        });

        $assignment->load(['equipment', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Equipment returned successfully',
            'data' => new AssignmentResource($assignment),
        ]);
    }
}
