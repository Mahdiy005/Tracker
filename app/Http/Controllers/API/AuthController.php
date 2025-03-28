<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        // serial generator
        $serial = generateSerial();

        
        $validated['serial'] = $serial;
        // salary bydefault is zero
        // Store Image
        if($request->hasFile('image')) {
            $image = $request->image;
            $newImgName = $serial . '.' . $image->getClientOriginalExtension();
            $image->storeAs('userImages', $newImgName, 'public');
            $validated['image'] = $newImgName;
        }
        // Generate Token for user
        $user = User::create($validated);
        $data['username'] = $user->name;
        $data['image'] = $user->image;
        $data['phone'] = $user->phone ?? 'Not Exist';
        $data['position'] = $user->position;
        $data['salary'] = $user->salary;
        $data['serial'] = $user->serial;
        // don't need token because the user not registered it just the admin add it to the system 
        // $data['token'] = $user->createToken('Registerd Token')->plainTextToken;
        if ($user) return ApiResponseSchema::sendResponse(201, 'Registered Successfully', $data);
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return ApiResponseSchema::sendResponse(401, 'Unauthorized: User not authenticated', []);
        }
        $user->currentAccessToken()->delete();
        return ApiResponseSchema::sendResponse(200, 'Loggedout Successfully');
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $user = $request->user();
            $data['username'] = $user->name;
            $data['image'] = $user->image;
            $data['phone'] = $user->phone;
            $data['position'] = $user->position;
            $data['salary'] = $user->salary;
            $data['serial'] = $user->serial;
            $data['token'] = $user->createToken('Login Token')->plainTextToken;
            $data['role'] = $user->role;
            return ApiResponseSchema::sendResponse(200, 'Logged in successfully', $data);
        }
        return ApiResponseSchema::sendResponse(401, 'Credentials Error');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        // handle image
        if ($request->hasFile('image')) {
            // Delete Old Image
            Storage::delete('public/userImages/' . $user->image);
            // handle new image 
            $image = $request->image;
            $newImgName = $user->serial . '.' . $image->getClientOriginalExtension();
            $image->storeAs('userImages', $newImgName, 'public');
            $validated['image'] = $newImgName;
        }

        // Ensure the authenticated user can only update their own profile
        if ($user->id !== Auth::id()) {
            return ApiResponseSchema::sendResponse(403, 'Unauthorized Action');
        }

        try {
            $user->update($validated);
            return ApiResponseSchema::sendResponse(200, 'Updated Successfully', []);
        } catch (\Exception $e) {
            Log::error('User profile update failed: ' . $e->getMessage());
            return ApiResponseSchema::sendResponse(500, 'An error occurred while updating the profile', []);
        }
    }

    public function userDetails(Request $request)
    {
        $user = $request->user();
        if ($user->id !== Auth::id()) {
            return ApiResponseSchema::sendResponse(403, 'Unauthorized Action');
        }
        return ApiResponseSchema::sendResponse(200, 'Retrived Successfully', new UserResource($user));
    }
}
