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

    public function normalUserPermissionsIds()
    {
        $default_user_permissions = array(
            'create-post',
            'view-posts',
            'update-post',
            'delete-post',
        );
        return $this->model->whereIn('name', $default_user_permissions)->pluck('id');
    }

    public function whereIn($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
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

    public function removeAdminPermissions(User $user)
    {
        $normal_user_permissions_ids = $this->normalUserPermissionsIds();
        $user->permissions()->sync($normal_user_permissions_ids);
        $user->touch();
    }

    public function removeAllPermissions(User $user)
    {
        $user->permissions()->detach();
    }

}
