<?php

namespace App\Repositories;

interface DepartmentRepositoryInterface extends RepositoryInterface
{
    /**
     * Get List With Pagination
     */
    public function getListWithPagination($params);
}
