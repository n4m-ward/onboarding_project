<?php

namespace Onboarding\Exercicio4\Database\Factories;

use Faker\Generator;
use Onboarding\Exercicio4\Database\UserDb;
use Onboarding\Exercicio4\Dto\UsuarioDto;

class UsuarioFactory extends BaseFactory
{
    public string $dtoClass = UsuarioDto::class;
    public string $dbClass = UserDb::class;

    protected function make(Generator $faker): array
    {
        return [
            'name' => $faker->name,
            'cep' => $faker->numerify('#####-###')
        ];
    }
}
