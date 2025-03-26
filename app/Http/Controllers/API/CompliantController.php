<?php

namespace App\Http\Controllers\API;

use App\Enums\CompliantStatus;
use App\Helpers\ApiResponseSchema;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompliantRequest;
use App\Http\Requests\UpdateCompliantRequest;
use App\Http\Resources\CompliantResourse;
use App\Models\Compliant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompliantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compliants = Compliant::paginate(8);

        if (count($compliants) > 0) {
            $data = PaginationHelper::formatPaginate($compliants, CompliantResourse::class);

            return ApiResponseSchema::sendResponse(200, 'Retieved Successfully', $data);
        }

        return ApiResponseSchema::sendResponse(200, 'No Compliants To retrieved', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompliantRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::user()->id;

            $created = Compliant::create($validated);
            DB::commit();
            if ($created) return ApiResponseSchema::sendResponse(201, 'Created Succefully', $created);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Comoliat Creation Error', $th->getMessage());
            return ApiResponseSchema::sendResponse(500, 'An error occurred while creating the resource.', null);
        }
    }

    /**
     * Display the specified resource. desplayCompliant
     */
    public function desplayCompliant($id)
    {
        $compliant = Compliant::find($id);

        if (! $compliant) {
            return ApiResponseSchema::sendResponse(404, 'Compiant Doesn\'t Exists', []);
        }

        // return $compliant;
        return ApiResponseSchema::sendResponse(200, 'Retrieved Succefully', new CompliantResourse($compliant));
    }

    /**
     * Display the authintcated user complaints 
     */
    public function displayMyComplaints()
    {
        $userComplaint = Compliant::where('user_id', Auth::id())->paginate(8);

        if(count($userComplaint) > 0) {
            $data = PaginationHelper::formatPaginate($userComplaint, CompliantResourse::class);
            return ApiResponseSchema::sendResponse(200, 'Retrived Succefully', $data);
        }
        return ApiResponseSchema::sendResponse(200, 'No Data To Retrived', NULL);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompliantRequest $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compliant $compliant)
    {
        //
    }
}
