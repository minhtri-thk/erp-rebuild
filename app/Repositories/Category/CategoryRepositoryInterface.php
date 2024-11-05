<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getAttributeWithCategoryId(int $id);

    /**
     * Get List With Pagination
     */
    public function getListWithPagination($params);
}
