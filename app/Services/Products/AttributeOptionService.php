<?php

namespace App\Services\Products;

use App\Repositories\AttributeOption\AttributeOptionRepositoryInterface;
use App\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface;

class AttributeOptionService
{
    private $categoryAttributeRepository;
    private $attributeOptionRepository;

    public function __construct(CategoryAttributeRepositoryInterface $categoryAttributeRepository, AttributeOptionRepositoryInterface $attributeOptionRepository)
    {
        $this->categoryAttributeRepository = $categoryAttributeRepository;
        $this->attributeOptionRepository = $attributeOptionRepository;
    }

    /**
     * Get List AttributeOption with Pagination
     *
     * @param  mixed $attribute_id
     * @param  mixed $request
     * @return mixed
     */
    public function getListAttributeOption($attribute_id, $request): mixed
    {
        return $this->attributeOptionRepository->getListWithPagination($attribute_id, $request);
    }

    /**
     * Create a AttributeOption
     *
     * @param  mixed $attribute_id
     * @param  mixed $request
     * @return mixed
     */
    public function createAttributeOption($attribute_id, $request): mixed
    {
        $categoryAttribute = $this->categoryAttributeRepository->find($attribute_id);
        return $categoryAttribute->options()->create($request->all());
    }

    /**
     * Show a AttributeOption
     *
     * @param  mixed $attribute_id
     * @param  mixed $id
     * @return mixed
     */
    public function showAttributeOption($attribute_id, $id): mixed
    {
        return $this->attributeOptionRepository->getFirstBy(['category_attribute_id' => $attribute_id, 'id' => $id]);
    }

    /**
     * Update a AttributeOption
     *
     * @param  mixed $attribute_id
     * @param  mixed $id
     * @param  mixed $request
     * @return mixed
     */
    public function updateAttributeOption($attribute_id, $id, $request): mixed
    {
        $attributeOption = $this->attributeOptionRepository->getFirstBy(['category_id' => $attribute_id, 'id' => $id]);
        return $attributeOption->update($request->all());
    }

    /**
     * Delete AttributeOption by Id
     *
     * @param  mixed $attribute_id
     * @param  mixed $id
     * @return mixed
     */
    public function deleteAttributeOption($attribute_id, $id): mixed
    {
        return $this->attributeOptionRepository->delete($id);
    }
}