<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Services\Users\UserService;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\UserProfileResource;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends BaseController implements HasMiddleware
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     *  Get the middleware that should be assigned to the controller.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('user-list'), only: ['index']),
            new Middleware(PermissionMiddleware::using('user-store'), only: ['store']),
            new Middleware(PermissionMiddleware::using('user-show'), only: ['show']),
            new Middleware(PermissionMiddleware::using('user-update'), only: ['update']),
            new Middleware(PermissionMiddleware::using('user-delete'), only: ['destroy']),
            // new Middleware(PermissionMiddleware::using('user-profile'), only: ['profile']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userService->getListUser($request);
            $results = new PaginationResource(UserProfileResource::collection($users));
            return $this->sendResponse(__(self::MSG_RETRIEVED), $results, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->createUserWithProfile($request->input());
            DB::commit();
            return $this->sendResponse(__(self::MSG_CREATED), $user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($uuid)
    {
        try {
            $user = $this->userService->getUserByUuid($uuid);
            if ($user) {
                $result = new UserProfileResource($user);
                return $this->sendResponse(__(self::MSG_RETRIEVED), $result, Response::HTTP_OK);
            }
            return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $uuid)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->updateUserWithProfile($uuid, $request->input());
            if ($user) {
                DB::commit();
                return $this->sendResponse(__(self::MSG_UPDATED), $user, Response::HTTP_OK);
            }
            return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $this->userService->deleteUserByUuid($uuid);
            DB::commit();
            return $this->sendResponse(__(self::MSG_DELETED), [], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show profile
     */
    public function profile()
    {
        try {
            $result = new UserProfileResource(Auth::user());
            return $this->sendResponse(__(self::MSG_RETRIEVED), $result, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
