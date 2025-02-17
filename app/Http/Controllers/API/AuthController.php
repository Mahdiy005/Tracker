<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponseSchema;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        // serial generator 
        $serial = IdGenerator::generate([
            'table' => 'users', 
            'field' => 'serial', 
            'length' => 8, 
            'prefix' => 'TRACKER-' ,
        ]);
        $validated['serial'] = $serial;
        // salary bydefault is zero
        // Store Image
        $image = $request->image;
        $newImgName = $serial . '.' . $image->getClientOriginalExtension();
        $image->storeAs('userImages', $newImgName, 'public');
        $validated['image'] = $newImgName;
        // Generate Token for user
        $user = User::create($validated);
        $data['username'] = $user->name;
        $data['image'] = $user->image;
        $data['phone'] = $user->phone;
        $data['position'] = $user->position;
        $data['salary'] = $user->salary;
        $data['serial'] = $user->serial;
        $data['token'] = $user->createToken('Registerd Token')->plainTextToken;
        if($user) return ApiResponseSchema::sendResponse(201, 'Registered Successfully', $data);
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        if(! $user) {
            return ApiResponseSchema::sendResponse(401, 'Unauthorized: User not authenticated', []);
        }
        $user->currentAccessToken()->delete();
        return ApiResponseSchema::sendResponse(200, 'Loggedout Successfully');
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();
        if(Auth::attempt($validated))
        {
            $user = $request->user();
            $data['username'] = $user->name;
            $data['image'] = $user->image;
            $data['phone'] = $user->phone;
            $data['position'] = $user->position;
            $data['salary'] = $user->salary;
            $data['serial'] = $user->serial;
            $data['token'] = $user->createToken('Login Token')->plainTextToken;
            return ApiResponseSchema::sendResponse(200, 'Logged in successfully', $data);
        }
        return ApiResponseSchema::sendResponse(401, 'Credentials Error');
    }
}
