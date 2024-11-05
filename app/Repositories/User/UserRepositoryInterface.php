<?php

namespace App\Repositories;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Get List With Pagination
     *
     * @return mixed
     */
    public function getListWithPagination($request);
}
