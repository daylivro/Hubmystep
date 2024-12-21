<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Actions\User\UpdateUserAction;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @group User
 * All user related endpoints
 * @authenticated
 */
class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Get the authenticated user details.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $this->authorize('view', $user);
        return $this->responseSuccess('User details', new UserResource($user));
    }

    /**
     * Update the authenticated user details.
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action)
    {
        $this->authorize('update', $user);
        $user = $action->execute($request->validated(), $user);
        return $this->responseSuccess(null, new UserResource($user));
    }

    /**
     * Delete the authenticated user.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return $this->responseSuccess('User deleted successfully');
    }

}
