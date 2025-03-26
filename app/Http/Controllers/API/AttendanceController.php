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
    public function allAttendance()
    {
        $attendances = Attendance::with('user')->paginate(8);
        if ($attendances) {
            // $data['paginate_data'] = AttendanceResource::collection($attendances);
            // $data['paginate_links'] = [
            //     'current_page' => $attendances->currentPage(),
            //     'last_page' => $attendances->lastPage(),
            //     'per_page' => $attendances->perPage(),
            //     'total' => $attendances->total(),
            //     'next_page_url' => $attendances->nextPageUrl(),
            //     'prev_page_url' => $attendances->previousPageUrl(),
            // ];

            $data = PaginationHelper::formatPaginate($attendances, AttendanceResource::class);
            return ApiResponseSchema::sendResponse('200', 'Attendances Retrived Succefully', $data);
        }
        return ApiResponseSchema::sendResponse(200, 'No Attendaces To retrived');
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
