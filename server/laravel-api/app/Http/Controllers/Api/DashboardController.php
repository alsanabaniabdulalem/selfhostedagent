<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $total = Equipment::query()->count();
        $available = Equipment::query()->where('status', 'available')->count();
        $assigned = Equipment::query()->where('status', 'assigned')->count();

        // Overdue: due date passed and not returned yet.
        $overdue = Assignment::query()
            ->whereNull('returned_at')
            ->whereDate('due_at', '<', now()->toDateString())
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard stats fetched',
            'data' => [
                'total' => $total,
                'available' => $available,
                'assigned' => $assigned,
                'overdue' => $overdue,
            ],
        ]);
    }
}
