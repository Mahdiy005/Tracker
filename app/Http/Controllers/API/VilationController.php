<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRole;
use App\Enums\VilationDetection;
use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVilationRequest;
use App\Http\Requests\UpdateVilationRequest;
use App\Http\Resources\ViolationResource;
use App\Models\User;
use App\Models\Vilation;
use Illuminate\Http\Request;

class VilationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $violations = Vilation::with('user')->get();
        if($violations && count($violations) > 0)
        {
            return ApiResponseSchema::sendResponse(200, 'Retrived Succefully', ViolationResource::collection($violations));
        }
        return ApiResponseSchema::sendResponse(200, 'No Violations To Received !');
    }

    public function getUserViolations(Request $request, $user_id)
    {
        $violations = Vilation::whereHas('user', function($query) use ($user_id) {
            return $query->where('id', $user_id);
        });
        if($request->has('date')) {
            $violations = $violations->whereDate('created_at', $request->input('date'));
        }
        $violations = $violations->get();

        if($violations && count($violations) > 0) {
            return ApiResponseSchema::sendResponse(200, 'Retrived Succefully', ViolationResource::collection($violations));
        }

        return ApiResponseSchema::sendResponse(200, 'No Violations For That User!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVilationRequest $request)
    {
        $validated = $request->validated();
        $validated['detected_by'] = VilationDetection::MANUAL;
        
        // images uploads
        if($request->hasFile('image')) {
            $image = $request->image;
            $newImageName = time() . '-' . $request->violation_type . '-' . User::find($request->user_id) . $image->getClientOriginalExtension();
            $image->storeAs('public', $newImageName, 'violationsImages');
            $validated['image'] = $newImageName;
        }

        if(User::find($request->user_id)->role === UserRole::ADMIN->value) {
            return ApiResponseSchema::sendResponse(403, 'Can\'t make violation to admin user');
        }

        $created = Vilation::create($validated);
        if($created) return ApiResponseSchema::sendResponse(201, 'Created Succefully', new ViolationResource($created));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($violation_id)
    {
        $violation = Vilation::find($violation_id);
        if(! $violation) return ApiResponseSchema::sendResponse(404, 'Not Found Violation');
        $deleted = $violation->delete();
        return ApiResponseSchema::sendResponse(200, 'Deleted Successfully', []);
    }
}
