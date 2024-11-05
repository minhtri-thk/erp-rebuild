<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Users\UserService;

class AuthController extends BaseController
{
    /**
     * Login user
     *
     * @param  [string] email
     * @param  [string] password
     */
    public function login(LoginRequest $request)
    {
        try {
            $result = App::make(UserService::class)->actionLogin($request);

            if (false == $result) {
                return $this->sendError(__('Unauthorized'), [], Response::HTTP_UNAUTHORIZED);
            }

            return $this->sendResponse(__('login successful'), [
                'accessToken' => $result,
                'token_type' => 'Bearer',
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Logout user
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->user()->tokens()->delete();
            return $this->sendResponse(__('logout successful'), []);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Register new user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $token = App::make(UserService::class)->registerNewUser($request->validated());
            DB::commit();
            return $this->sendResponse(__('you have successfully created objects'), [
                'accessToken' => $token,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError($th->getMessage());
        }
    }
}
