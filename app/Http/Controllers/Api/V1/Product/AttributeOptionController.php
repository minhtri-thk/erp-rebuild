<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Core\Transformers\PaginationResource;
use App\Http\Requests\Product\CreateOptionRequest;
use App\Services\Product\AttributeOptionService;
use App\Transformers\AttributeOptionResource;

class AttributeOptionController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $attribute_id)
    {
        try {
            $attributeOptions = App::make(AttributeOptionService::class)->getListAttributeOption($attribute_id, $request);
            $results = new PaginationResource(AttributeOptionResource::collection($attributeOptions));
            return $this->sendResponse(__('you have successfully retrieved the information'), $results, Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOptionRequest $request, $attribute_id)
    {
        try {
            $attributeOption = App::make(AttributeOptionService::class)->createAttributeOption($attribute_id, $request);
            return $this->sendResponse(__('you have successfully created objects'), $attributeOption, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($attribute_id, $id)
    {
        try {
            $attributeOption = App::make(AttributeOptionService::class)->showAttributeOption($attribute_id, $id);
            if ($attributeOption) {
                return $this->sendResponse(__('you have successfully retrieved the information'), $attributeOption, Response::HTTP_OK);
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
    public function update(CreateOptionRequest $request, $attribute_id, $id)
    {
        try {
            $attributeOption = App::make(AttributeOptionService::class)->updateAttributeOption($attribute_id, $id, $request);
            if ($attributeOption) {
                return $this->sendResponse(__('you have successfully modified objects'), $attributeOption, Response::HTTP_OK);
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
    public function destroy($attribute_id, $id)
    {
        try {
            App::make(AttributeOptionService::class)->deleteAttributeOption($attribute_id, $id);
            return $this->sendResponse(__('you have successfully deleted objects'), [], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . ' - Line:' . $th->getLine());
            return $this->sendError(__('an error occurred during processing'), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
