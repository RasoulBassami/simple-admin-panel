<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getAllUsersWithQueryString();

//    public function filterThroughTheGate(string $ability, $users);
    public function filterViewableUsers($users);

    public function create($data);

    public function update($user, $data);

    public function delete($user);
}
