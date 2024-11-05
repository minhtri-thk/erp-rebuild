<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get model deparmtnet
     *
     * @return mixed
     */
    public function getModel()
    {
        return Department::class;
    }

    /**
     * Get List With Pagination
     *
     * @param  mixed $request
     * @return mixed
     */
    public function getListWithPagination($request)
    {
        $data = $this->model->filter($request)->sort($request)->applyLimit($request);
        return $data;
    }
}
