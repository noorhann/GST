<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UsersSingleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return  json()
     * Login User using email and password
     */
    public function login(LoginRequest $request)
    {
        try {

            $credentials = $request->only(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return apiResponse(
                    false,
                    'The Email address or password you entered is incorrect',
                    422,
                );
            }
            $message = 'You Logged in Successfully';
            $data['user'] = new UsersSingleResource(auth()->user());
            $data['token'] = $token;
            return $this->respondWithToken($data, $message);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * @param CreateUsersRequest $request
     * @return  json()
     * Create User
     */
    public function register(CreateUsersRequest $request)
    {
        try {
            $request['password'] = bcrypt($request->password);
            $user = User::create($request->all());
            $user['token'] = auth()->login($user);
            $message = 'User Created Successfully';
            return $this->respondWithToken($user, $message);
        } catch (\Throwable $th) {
            dd($th);
            Log::error($th);
        }
    }

    /**
     * @param Request $request
     * @return  json()
     * Logout Admin
     */
    public function logout(Request $request)
    {
        try {
            auth()->logout();
            return apiResponse(
                true,
                'You logged out successfully',
                200,
            );
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($data, $message)
    {
        return apiResponse(
            true,
            $message,
            200,
            $data,
        );
    }
}