<?php

namespace Onboarding\Exercicio4\Database;

use Onboarding\Exercicio4\Dto\UsuarioDto;

class UsuarioDb extends BaseDb
{
    public string $table = 'usuario';
    public string $dtoClass = UsuarioDto::class;
}
