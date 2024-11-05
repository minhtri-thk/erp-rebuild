<?php

namespace App\Http\Controllers\Api\V1\Departments;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Departments\DepartmentRequest;
use App\Http\Resources\PaginationResource;
use App\Services\Departments\DepartmentService;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DepartmentController extends BaseController
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('department-list'), only: ['index']),
            new Middleware(PermissionMiddleware::using('department-store'), only: ['store']),
            new Middleware(PermissionMiddleware::using('department-show'), only: ['show']),
            new Middleware(PermissionMiddleware::using('department-update'), only: ['update']),
            new Middleware(PermissionMiddleware::using('department-delete'), only: ['destroy']),
        ];
    }

    /**
     * Get a list of Departments based on the specified conditions in the request.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $list = App::make(DepartmentService::class)->getListDepartment($request);
            $results = new PaginationResource($list);
            return $this->sendResponse(__(self::MSG_RETRIEVED), $results);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create a new department with the specified data from the request.
     *
     * @param App\Http\Requests\DepartmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = App::make(DepartmentService::class)->createDepartment($request);
            DB::commit();
            return $this->sendResponse(__(self::MSG_CREATED), $data);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get the details of a specific department.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data = App::make(DepartmentService::class)->showDepartment($id);
            if (empty($data)) {
                return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
            }
            return $this->sendResponse(__(self::MSG_RETRIEVED), $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified department with new data.
     *
     * @param int $id
     * @param \App\Http\Requests\DepartmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, DepartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = App::make(DepartmentService::class)->updateDepartment($id, $request);
            if ($data) {
                DB::commit();
                return $this->sendResponse(__(self::MSG_UPDATED), $data);
            }
            return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified department from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            App::make(DepartmentService::class)->deleteDepartment($id);
            DB::commit();
            return $this->sendResponse(__(self::MSG_DELETED), [], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
