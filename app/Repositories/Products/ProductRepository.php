<?php

namespace App\Repositories\Products;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return Product::class;
    }

    // /**
    //  * Get List With Pagination
    //  *
    //  * @param  mixed $request
    //  * @return mixed
    //  */
    // public function getListWithPagination($request)
    // {
    //     $results = $this->model->filter($request)->sort($request)->applyLimit($request);
    //     return $results;
    // }

    public function getCategoryAttribute(int $id)
    {
        return Category::with(
            [
                'attributes.options'
            ]
        )->where('categories.id', $id)->get();
    }
}
