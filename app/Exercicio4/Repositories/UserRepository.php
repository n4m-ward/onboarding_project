<?php

namespace Onboarding\Exercicio4\Repositories;

use Onboarding\Exercicio4\Database\UserDb;
use Onboarding\Exercicio4\Dto\UserDto;

class UserRepository
{
    public function getUserById(int $userId): UserDto
    {
        return (new UserDb())->getAll()
            ->where('id', '=', $userId)->first();
    }
}
