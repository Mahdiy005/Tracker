<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRepliesRequest;
use App\Http\Requests\UpdateComplaintRepliesRequest;
use App\Http\Resources\CompliantRepliesResource;
use App\Models\ComplaintReplies;
use App\Models\Compliant;
use Illuminate\Support\Facades\Auth;

class ComplaintRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * this will send `status` and `reply-message`
     */
    public function store(StoreComplaintRepliesRequest $request, $compliant_id)
    {
        $targetCompliant = Compliant::where('id', $compliant_id);
        if(! $targetCompliant->exists()) {
            return ApiResponseSchema::sendResponse(404, 'Complaint not found');
        }

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        $validated['compliant_id'] = $compliant_id;

        // alter the status of the compliant
        $status = $validated['status'];
        unset($validated['status']);
        $targetCompliant->update([
            'status' => $status,
        ]);
        
        $created = ComplaintReplies::create($validated);
        if($created) return ApiResponseSchema::sendResponse(200, 'Created Succefully', new CompliantRepliesResource($created));
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplaintReplies $complaintReplies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplaintReplies $complaintReplies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRepliesRequest $request, ComplaintReplies $complaintReplies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($compliant_id)
    {
        $targetReply = ComplaintReplies::find($compliant_id);
        if(! $targetReply) {
            return ApiResponseSchema::sendResponse(404, 'Compliant Not Found');
        }

        if(Auth::id() !== $targetReply->user_id) {
            return ApiResponseSchema::sendResponse(403, 'Not Allowed This Action For you');
        }

        $deleted = $targetReply->delete();

        if($deleted) return ApiResponseSchema::sendResponse(200, 'Deleted Succefully');
    }
}
