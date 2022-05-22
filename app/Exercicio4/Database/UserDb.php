<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\UsuarioFactory;
use Onboarding\Exercicio4\Dto\UserDto;

class UserDb extends BaseDb
{
    public string $table = 'user';
    public string $dtoClass = UserDto::class;
    public string $factoryClass = UsuarioFactory::class;
}
