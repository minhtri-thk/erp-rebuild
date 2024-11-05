<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PaginationResource;
use App\Http\Requests\Products\CreateAttributeRequest;
use App\Services\Products\CategoryAttributeService;
use App\Http\Resources\CategoryAttributeResource;

class CategoryAttributeController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category_id)
    {
        try {
            $categoryAttributes = App::make(CategoryAttributeService::class)->getListCategoryAttribute($category_id, $request);
            $results = new PaginationResource(CategoryAttributeResource::collection($categoryAttributes));
            return $this->sendResponse(__('you have successfully retrieved the information'), $results, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAttributeRequest $request, $category_id)
    {
        try {
            $categoryAttribute = App::make(CategoryAttributeService::class)->createCategoryAttribute($category_id, $request);
            return $this->sendResponse(__('you have successfully created objects'), $categoryAttribute, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($category_id, $id)
    {
        try {
            $categoryAttribute = App::make(CategoryAttributeService::class)->showCategoryAttribute($category_id, $id);
            if ($categoryAttribute) {
                return $this->sendResponse(__('you have successfully retrieved the information'), $categoryAttribute, Response::HTTP_OK);
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
    public function update(CreateAttributeRequest $request, $category_id, $id)
    {
        try {
            $categoryAttribute = App::make(CategoryAttributeService::class)->updateCategoryAttribute($category_id, $id, $request);
            if ($categoryAttribute) {
                return $this->sendResponse(__('you have successfully modified objects'), $categoryAttribute, Response::HTTP_OK);
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
    public function destroy($category_id, $id)
    {
        try {
            App::make(CategoryAttributeService::class)->deleteCategoryAttribute($category_id, $id);
            return $this->sendResponse(__('you have successfully deleted objects'), [], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
