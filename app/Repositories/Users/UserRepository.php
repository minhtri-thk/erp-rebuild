<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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
        return User::class;
    }
    /**
     * Get List With Pagination
     *
     * @param  mixed $request
     * @return mixed
     */
    public function getListWithPagination($request)
    {
        $data = $this->model->with(['profile', 'departments'])
            ->filter($request)
            ->sort($request)
            ->applyLimit($request);

        return $data;
    }
}
