<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Core\Transformers\PaginationResource;
use App\Http\Requests\Product\CreateCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Services\Product\CategoryService;
use App\Transformers\CategoryResource;

class CategoryController extends BaseController
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $categories = App::make(CategoryService::class)->getListCategory($request);
            $results = new PaginationResource(CategoryResource::collection($categories));
            return $this->sendResponse(__('you have successfully retrieved the information'), $results, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $category = App::make(CategoryService::class)->createCategory($request);
            return $this->sendResponse(__('you have successfully created objects'), $category, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            dd($th);
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $category = App::make(CategoryService::class)->showCategory($id);
            if ($category) {
                return $this->sendResponse(__('you have successfully retrieved the information'), $category, Response::HTTP_OK);
            }

            return $this->sendError(__('Not Found'), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = App::make(CategoryService::class)->updateCategory($id, $request);
            if ($category) {
                return $this->sendResponse(__('you have successfully modified objects'), $category, Response::HTTP_OK);
            }
            return $this->sendError(__('Not Found'), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            App::make(CategoryService::class)->deleteCategory($id);
            return $this->sendResponse(__('you have successfully deleted objects'), [], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getCategoryById($id)
    {
        try {
            $category = App::make(CategoryService::class)->getAttributeWithCategoryId($id);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError($th->getMessage(), [], Response::HTTP_OK);
        }
    }
}
