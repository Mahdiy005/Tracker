<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRole;
use App\Helpers\ApiResponseSchema;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function allAttendance(Request $request)
    {
        // Start with base query
        $query = Attendance::with('user');

        // Apply date filter if present
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // Apply date filter if present
        if ($request->filled('month')) {
            // i need if query parameter month is * then i need to get all records
            if($request->input('month') == '*') {
                $query->whereMonth('created_at', '!=', null);
            } else {
                $query->whereMonth('created_at', $request->input('month'));
            }
        }

        // Apply status filter if present
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Reset to first page when new filters are applied
        if ($request->hasAny(['date', 'status']) && !$request->has('page')) {
            $request->merge(['page' => 1]);
        }

        // Paginate the filtered results
        $attendances = $query->paginate(2)->appends($request->query());

        // Format response
        if ($attendances->isNotEmpty()) {
            $data = PaginationHelper::formatPaginate($attendances, AttendanceResource::class);
            return ApiResponseSchema::sendResponse('200', 'Attendances Retrieved Successfully', $data);
        }

        return ApiResponseSchema::sendResponse(200, 'No Attendances To retrieve');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $status)
    {
        $date = $request->input('date') ? Carbon::parse($request->input('date'))->toDateString() : null;

        $attendances = Attendance::with('user')->where('status', $status)->whereHas('user', function ($query) {
                return $query->where('role', '!=', UserRole::ADMIN->value);
            });

        if ($date) {
            $attendances->whereDate('created_at', $date);
        }

        // Execute query
        $attendances = $attendances->paginate(8);

        if ($attendances->isNotEmpty()) {
            $data = PaginationHelper::formatPaginate($attendances, AttendanceResource::class);
            return ApiResponseSchema::sendResponse('200', $status . ' user retrived succefully', $data);
        }
        return ApiResponseSchema::sendResponse(200, 'No Attendaces To retrived');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request, $user_id)
    {
        if (! User::where('id', $user_id)->exists()) {
            return ApiResponseSchema::sendResponse(404, 'User not found', null);
        }
        $validated = $request->validated();
        $validated['user_id'] = $user_id;
        $created = Attendance::create($validated);
        if ($created) return ApiResponseSchema::sendResponse(201, 'Added Successfully', new AttendanceResource($created));
    }

    /**
     * Display the specified resource.
     */
    public function getUserAttendance(int $user_id)
    {
        $userAttendance = Attendance::with('user')->where('user_id', $user_id)->paginate(8);
        if ($userAttendance->isNotEmpty()) {
            $data = PaginationHelper::formatPaginate($userAttendance, AttendanceResource::class);
            return ApiResponseSchema::sendResponse(200, 'Retrived Succefully', $data);
        }
        return ApiResponseSchema::sendResponse(200, 'No Data Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
