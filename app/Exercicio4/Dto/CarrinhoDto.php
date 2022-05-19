<?php

namespace Onboarding\Exercicio4\Dto;

use Tightenco\Collect\Support\Collection;

class CarrinhoDto extends BaseTableDto
{
    public int $usuarioId;

    /**
     * @var Collection
     */
    public Collection $listaDeCompras;
}
