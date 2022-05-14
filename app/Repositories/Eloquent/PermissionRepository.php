<?php
namespace App\Repositories\Eloquent;
use App\Models\Permission;
use \App\Models\User;
use App\Repositories\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function adminPermissions()
    {
        return $this->model->where('name', '!=' , 'create-post')->get();
    }

    public function store(User $user, $data)
    {
        $user->permissions()->sync($data);
    }

    public function update(User $user, $permissions)
    {
        $user->permissions()->sync($permissions);
        $user->touch();
    }

    public function removeAllPermissions(User $user)
    {
        $user->permissions()->detach();
    }

}
