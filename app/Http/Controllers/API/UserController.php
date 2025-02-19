<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRole;
use App\Helpers\ApiResponseSchema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserFAdminResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', UserRole::ADMIN->value)->get();
        if ($users && count($users) > 0) {
            return ApiResponseSchema::sendResponse(200, 'Retrived Successfully', UserFAdminResource::collection($users));
        }
        return ApiResponseSchema::sendResponse(200, 'No Data To Retrived', []);
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        if (! $user) {
            return ApiResponseSchema::sendResponse(200, 'User Not Exist', []);
        }
        return ApiResponseSchema::sendResponse(200, 'Retrived Successfully', new UserFAdminResource($user));
    }

    public function promote($user_id)
    {
        $user = User::find($user_id);

        if (! $user) {
            return ApiResponseSchema::sendResponse(200, 'User Not Exist', []);
        }

        if ($user->role === UserRole::ADMIN->value) {
            return ApiResponseSchema::sendResponse(200, 'That User Is Already Admin');
        }

        $success = $user->update(['role' => UserRole::ADMIN->value]);

        if ($success) return ApiResponseSchema::sendResponse(200, 'Promoted Succefully');
    }

    public function demote($user_id)
    {
        $user = User::find($user_id);

        if (! $user) {
            return ApiResponseSchema::sendResponse(200, 'User Not Exist', []);
        }

        if ($user->role === UserRole::USER->value) {
            return ApiResponseSchema::sendResponse(200, 'That User Is Already Not Admin');
        }

        $success = $user->update(['role' => UserRole::USER->value]);

        if ($success) return ApiResponseSchema::sendResponse(200, 'Demoted Succefully');
    }
}
