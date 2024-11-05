<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCategoryAttribute(int $id)
    {
        return $this->productRepository->getCategoryAttribute($id);
    }

    /**
     * Create a Product
     *
     * @param  array $attributes
     * @return mixed
     */
    public function createProduct($request): mixed
    {
        $attributes = $request->input('products') ?? [];
        return $this->productRepository->create($attributes);
    }

    // /**
    //  * Get List Product with Pagination
    //  *
    //  * @param  mixed $request
    //  * @return mixed
    //  */
    // public function getListProduct($request): mixed
    // {
    //     return $this->productRepository->getListWithPagination($request);
    // }

    // /**
    //  * Show a Product
    //  *
    //  * @param  mixed $id
    //  * @return mixed
    //  */
    // public function showProduct($id): mixed
    // {
    //     return $this->productRepository->find($id);
    // }

    // /**
    //  * Update a Product
    //  *
    //  * @param  mixed $id
    //  * @param  mixed $attributes
    //  * @return mixed
    //  */
    // public function updateProduct($id, $request): mixed
    // {
    //     $attributes = $request->all();
    //     return $this->productRepository->update($id, $attributes);
    // }

    // /**
    //  * Delete Product by Id
    //  *
    //  * @param  mixed $id
    //  * @return mixed
    //  */
    // public function deleteProduct($id): mixed
    // {
    //     return $this->productRepository->delete($id);
    // }

}
