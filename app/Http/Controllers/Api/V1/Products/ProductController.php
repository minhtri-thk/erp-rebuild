<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Products\CreateProductRequest;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        try {
            $categoryAttributes = App::make(ProductService::class)->createProduct($request);
            if ($categoryAttributes) {
                return $this->sendResponse(__(self::MSG_RETRIEVED), $categoryAttributes);
            }

            return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * get Category Attribute
     *
     * @param  int $id
     * @return mixed
     */
    public function getCategoryAttribute(int $id): JsonResponse
    {
        try {
            $categoryAttributes = App::make(ProductService::class)->getCategoryAttribute($id);
            if ($categoryAttributes) {
                return $this->sendResponse(__(self::MSG_RETRIEVED), $categoryAttributes);
            }

            return $this->sendError(__(self::MSG_NOT_FOUND), [], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__(self::MSG_ERROR), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
