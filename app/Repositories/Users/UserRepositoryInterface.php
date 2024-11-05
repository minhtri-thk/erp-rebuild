<?php

namespace App\Repositories\Users;
use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Get List With Pagination
     *
     * @return mixed
     */
    public function getListWithPagination($request);
}
