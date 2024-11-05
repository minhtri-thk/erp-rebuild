<?php

namespace App\Repositories\AttributeOption;

use App\Repositories\RepositoryInterface;

interface AttributeOptionRepositoryInterface extends RepositoryInterface
{

    /**
     * Get List With Pagination
     */
    public function getListWithPagination($attribute_id, $request);
}
