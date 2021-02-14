<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function findById($id);

    public function findByUsername($username);

    public function findProfile($where, $authId);
}
