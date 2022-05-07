<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\User;

interface PermissionRepositoryInterface
{
    public function adminPermissions();

    public function normalUserPermissionsIds();

    public function store(User $user, $data);

    public function update(User $permission, $data);

    public function removeAdminPermissions(User $user);

    public function removeAllPermissions(User $user);
}
