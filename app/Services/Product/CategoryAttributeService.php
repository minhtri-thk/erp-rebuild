<?php

namespace App\Services\Product;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface;

class CategoryAttributeService
{
    private $categoryRepository;
    private $categoryAttributeRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryAttributeRepositoryInterface $categoryAttributeRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * Get List CategoryAttribute with Pagination
     *
     * @param  mixed $category_id
     * @param  mixed $request
     * @return mixed
     */
    public function getListCategoryAttribute($category_id, $request): mixed
    {
        return $this->categoryAttributeRepository->getListWithPagination($category_id, $request);
    }

    /**
     * Create a CategoryAttribute
     *
     * @param  mixed $category_id
     * @param  mixed $request
     * @return mixed
     */
    public function createCategoryAttribute($category_id, $request): mixed
    {
        $category = $this->categoryRepository->find($category_id);
        return $category->attributes()->create($request->all());
    }

    /**
     * Show a CategoryAttribute
     *
     * @param  mixed $category_id
     * @param  mixed $id
     * @return mixed
     */
    public function showCategoryAttribute($category_id, $id): mixed
    {
        return $this->categoryAttributeRepository->getFirstBy(['category_id' => $category_id, 'id' => $id]);
    }

    /**
     * Update a CategoryAttribute
     *
     * @param  mixed $category_id
     * @param  mixed $id
     * @param  mixed $request
     * @return mixed
     */
    public function updateCategoryAttribute($category_id, $id, $request): mixed
    {
        $categoryAttribute = $this->categoryAttributeRepository->getFirstBy(['category_id' => $category_id, 'id' => $id]);
        return $categoryAttribute->update($request->all());
    }

    /**
     * Delete CategoryAttribute by Id
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteCategoryAttribute($category_id, $id): mixed
    {
        return $this->categoryAttributeRepository->delete($id);
    }
}