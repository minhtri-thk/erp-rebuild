<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    const TOKEN_NAME = 'thk-token';

    private $userRepository;
    private $userProfileRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Login User
     *
     * Return Token || false
     */
    public function actionLogin($request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (!Auth::attempt($credentials, $request->remember ?? false)) {
            return false;
        }

        $user = $request->user();
        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return $token;
    }

    /**
     * Register new user
     *
     * Return Token
     */
    public function registerNewUser($request)
    {
        $user = $this->userRepository->create($request);
        if ($user) {
            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;
            return $token;
        }
        return false;
    }
    /**
     * Get List User with Pagination
     *
     * @param  mixed $request
     * @return mixed
     */
    public function getListUser($request): mixed
    {
        return $this->userRepository->getListWithPagination($request);
    }

    /**
     * Create a User
     *
     * @param  mixed $request
     * @return mixed
     */
    public function createUserWithProfile($request): mixed
    {
        $user = $this->userRepository->create($request);
        if ($user) {
            $attributes = [
                'user_id' => $user->id,
            ];
            $user->departments()->syncWithPivotValues($request['department_ids'], [
                'created_by' => Auth::id() ?? 0,
                'updated_by' => Auth::id() ?? 0
            ]);
            $userProfileData = array_merge($request, $attributes);
            $userProfile = $this->userProfileRepository->create($userProfileData);

            return $userProfile;
        }

        return false;
    }

    /**
     * Update a User
     *
     * @param  mixed $uuid
     * @param  mixed $request
     * @return mixed
     */
    public function updateUserWithProfile($uuid, $request): mixed
    {
        $attributes = [
            'email' => Arr::get($request, 'email'),
        ];
        $user = $this->userRepository->updateByUuid($uuid, $attributes);
        if ($user) {
            if (isset($request['department_ids']) && !empty($request['department_ids'])) {
                $user->departments()->sync($request['department_ids']);
            }
            $userProfile = $user->profile()->first();
            if ($userProfile) {
                return $userProfile->fill($request)->save();
            }
        }

        return false;
    }

    /**
     * Get a User
     *
     * @param  mixed $uuid
     * @return mixed
     */
    public function getUserByUuid($uuid): mixed
    {
        $userProfile = $this->userRepository->findByUuid($uuid);

        return $userProfile;
    }

    /**
     * Delete a User
     *
     * @param  mixed $uuid
     * @return mixed
     */
    public function deleteUserByUuid($uuid): mixed
    {
        $user = $this->userRepository->findByUuid($uuid);
        if ($user) {
            // delete User
            $user->delete();
            // delete Profile
            $user->profile->delete();
            return true;
        }
        return false;
    }
}
