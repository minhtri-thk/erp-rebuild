<?php

namespace App\Repositories\Permissions;

use App\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class PermissionRepository extends BaseRepository implements RepositoryInterface
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
        return Permission::class;
    }

    /**
     * Get List With Pagination
     *
     * @param  mixed $request
     * @return mixed
     */
    public function getListWithPagination($request)
    {
        $results = $this->model->filter($request)->sort($request)->applyLimit($request);
        return $results;
    }
}
