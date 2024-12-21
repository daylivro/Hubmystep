<?php

namespace App\Http\Controllers\API;

use App\Services\Otp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\User\CreateUserAction;
use App\Http\Requests\User\AuthRequest;
use App\Actions\UserMile\NewMouvmentAction;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Actions\Auth\UpdateUserPasswordAction;
use App\Http\Requests\Auth\PasswordForgotRequest;
use App\Notifications\Auth\OneTimePasswordNotification;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
/**
 * @group Auth
 * This is the Auth controller
 * @unauthenticated
 */
class AuthController extends Controller
{
    /**
     * Get a Bearer token
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return $this->responseUnprocessable(__('Invalid credentials'));
        }

        if(! auth()->user()->isActive()){
            auth()->logout();
            return $this->responseUnprocessable(__('Your account is not active. Contact our support'));
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        return $this->responseSuccess(__('Login success'), $token);
    }

    /**
     * Register a new user
     * @param AuthRequest $request
     * @param CreateUserAction $action
     * @return JsonResponse
     */
    public function register(AuthRequest $request, CreateUserAction $action, NewMouvmentAction $newMouvment): JsonResponse
    {
        $user = $action->execute($request->validated());
        if ($request->referal_code) {
            $sponsor = \App\Models\User::where('referal_code', $request->referal_code)->first();
            if ($sponsor) {
                $sponsor->userMile->miles += 2;
                $sponsor->userMile->save();
                $newMouvment->execute([
                    'user_id' => $sponsor->id,
                    'miles' => 2,
                    'movement' => 'in',
                    'mouvmentable_type' => 'App\Models\User',
                    'mouvmentable_id' => $user->id,
                ]);
            }
        }
        return $this->responseSuccess('Register success');
    }

    /**
     * Reset password
     * Send an email to reset password
     */
    public function passwordForgot(AuthRequest $request): JsonResponse
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return $this->responseNotFound('User not found');
        }

        $otp = Otp::generate($request->email);
        $user->notify(new OneTimePasswordNotification($otp->token));
        return $this->responseSuccess('OTP sent to your email');
    }

    /**
     * Reset password
     * Reset the password with the token
     */
    public function passwordReset(AuthRequest $request, UpdateUserPasswordAction $action): JsonResponse
    {
        $user = \App\Models\User::where('email', $request->email)->first();
        $action->execute($user, $request->password);
        return $this->responseSuccess('Password reset success');
    }

    /**
     * Logout
     * Revoke the token
     * @authenticated
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return $this->responseSuccess('Logout success');
        return $this->responseWithCustomError('Logout Sucess', null, HttpFoundationResponse::HTTP_NO_CONTENT);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(AuthRequest $request)
    {
        $otpIsValid = Otp::verify($request->email, $request->token);
        if (!$otpIsValid) {
            return $this->responseBadRequest('Invalid OTP');
        }

        return $this->responseSuccess('OTP verified');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(AuthRequest $request)
    {
    }
}
