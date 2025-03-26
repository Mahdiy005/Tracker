<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseSchema;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainedImageRequest;
use App\Http\Requests\UpdateTrainedImageRequest;
use App\Http\Resources\TrainedImageResource;
use App\Models\TrainedImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainedImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = TrainedImage::where('user_id', Auth::user()->id)->paginate(8);
        
        if($images && count($images) > 0) {
            $data = PaginationHelper::formatPaginate($images, TrainedImageResource::class);
            return ApiResponseSchema::sendResponse(200, 'Retrived Successfully', $data);
        }
        return ApiResponseSchema::sendResponse(200, 'No Images To Retrived !');
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
     */
    public function store(StoreTrainedImageRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $validated['user_id'] = $user->id;
        // Store Image
        $image = $request->image;
        $newImageName = $user->serial . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('trainedUserImages', $newImageName, 'public');
        $validated['image'] = $newImageName;

        $is_created = TrainedImage::create($validated);
        if($is_created) return ApiResponseSchema::sendResponse(200, 'Created Succefully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainedImage $trainedImage)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainedImage $trainedImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainedImageRequest $request, TrainedImage $trainedImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $img_id)
    {
        $user = $request->user();
        $image = $user->trainedImages()->where('id', $img_id)->first();

        if(! $image) {
            return ApiResponseSchema::sendResponse(403, 'No Image To Delete');
        }

        // Delete Image From Storage
        Storage::delete('public/trainedUserImages/' . $image->image);

        $image->delete();

        return ApiResponseSchema::sendResponse(200, 'Deleted Successfully');
    }
}
