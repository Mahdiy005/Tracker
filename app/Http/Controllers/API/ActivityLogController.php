<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRole;
use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityLogRequest;
use App\Http\Requests\UpdateActivityLogRequest;
use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activityLogs = ActivityLog::with('user');

        if ($request->has('date')) {
            $activityLogs = $activityLogs->whereDate('created_at', $request->input('date'));
        }

        $activityLogs = $activityLogs->get();

        if ($activityLogs && count($activityLogs) > 0) {
            return ApiResponseSchema::sendResponse(200, 'Rerived Successfully', ActivityLogResource::collection($activityLogs));
        }

        return ApiResponseSchema::sendResponse(200, 'No Data To Retrived');
    }


    public function getActivLogForUser(Request $request, $user_id)
    {
        // Only Admin and The User That Have Logs Allowed
        if ($request->user()->id == $user_id || $request->user()->role === UserRole::ADMIN) {
            $activityLogs = ActivityLog::where('user_id', $user_id)->get();

            if ($activityLogs->isNotEmpty()) {
                return ApiResponseSchema::sendResponse(200, 'Retrived Succefully', ActivityLogResource::collection($activityLogs));
            }

            return ApiResponseSchema::sendResponse(200, 'No Data To Retrived');
        }

        Log::warning("Unauthorized access attempt by User ID: " . $request->user()->id);
        return ApiResponseSchema::sendResponse(403, 'Forbidden: Unauthorized Action');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityLogRequest $request)
    {
        // todo:: ai will store them automatically 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $activityLogID)
    {
        $activityLog = ActivityLog::find($activityLogID);

        if($request->user()->role !== UserRole::ADMIN->value) {
            return ApiResponseSchema::sendResponse(403, 'Not Allowed', []);
        }
        $is_delete = $activityLog->delete();
        if($is_delete) return ApiResponseSchema::sendResponse(200, 'Deleted Succefully', []);
    }
}