<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Database\Factories\UsuarioFactory;
use Onboarding\Exercicio4\Dto\UsuarioDto;

class UserDb extends BaseDb
{
    public string $table = 'usuario';
    public string $dtoClass = UsuarioDto::class;
    public string $factoryClass = UsuarioFactory::class;
}
