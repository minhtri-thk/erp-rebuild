<?php

namespace App\Repositories;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * Get List With Pagination
     */
    public function getListWithPagination($params);
}
