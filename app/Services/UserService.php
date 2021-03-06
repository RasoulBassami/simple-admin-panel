<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    protected $userRepository;
    protected $permissionRepository;
    protected $postRepository;

    public function __construct(UserRepositoryInterface $userRepository, PermissionRepositoryInterface $permissionRepository, PostRepositoryInterface $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
        $this->postRepository = $postRepository;
    }

    public function getAllUsersWithQueryString()
    {
        return $this->userRepository->getAllUsersWithQueryString();
    }

//    public function filterThroughTheGate(string $ability, $users)
//    {
//        return $this->userRepository->filterThroughTheGate($ability, $users);
//    }

    public function filterViewableUsers($users)
    {
        return $this->userRepository->filterViewableUsers($users);
    }

    public function paginateUsers($users, $perPage = 10)
    {
        return $this->userRepository->paginateUsers($users);
    }

    public function adminPermissions()
    {
        return $this->permissionRepository->adminPermissions();
    }

    public function storeUser($user_data)
    {
        $user_data['password'] = bcrypt($user_data['password']);
        $user = $this->userRepository->create($user_data);

        if (! empty($user_data['permission']))
            $this->permissionRepository->store($user, $user_data['permission']);
    }

    public function updateUser($request, User $user)
    {
        $user_data = $request->all();

        if ($request->has('is_admin')) {
            $user_data['is_admin'] = 1;
            $this->permissionRepository->update($user, $user_data['permission']);
        } else {
            $user_data['is_admin'] = 0;
            $this->permissionRepository->removeAllPermissions($user);
        }

        if ($request->has('password'))
            $user_data['password'] = bcrypt($user_data['password']);

        $this->userRepository->update($user, $user_data);
    }

    public function removeUser(User $user)
    {
        $this->permissionRepository->removeAllPermissions($user);

        if($user->hasPost()) {
            $posts = $user->posts;
            $this->postRepository->deleteMany($posts);
        }

        $this->userRepository->delete($user);
    }
}
