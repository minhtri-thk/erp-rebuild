<?php

namespace App\Repositories;

use App\Models\UserProfile;
use App\Repositories\UserProfileRepositoryInterface;

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
