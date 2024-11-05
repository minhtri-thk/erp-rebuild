<?php

namespace App\Repositories\Users;

use App\Models\UserProfile;
use App\Repositories\Users\UserProfileRepositoryInterface;
use App\Repositories\RepositoryInterface;
use App\Repositories\BaseRepository;

class UserProfileRepository extends BaseRepository implements UserProfileRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Model
     *
     * @return string
     */
    public function getModel()
    {
        return UserProfile::class;
    }
}
