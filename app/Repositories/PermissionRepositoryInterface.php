<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\User;

interface PermissionRepositoryInterface
{
    public function adminPermissions();

    public function store(User $user, $data);

    public function update(User $permission, $data);

    public function removeAllPermissions(User $user);
}
