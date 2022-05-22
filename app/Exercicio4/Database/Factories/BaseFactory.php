<?php

namespace Onboarding\Exercicio4\Database\Factories;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Onboarding\Exercicio4\Database\BaseDb;
use Onboarding\Exercicio4\Dto\BaseTableDto;
use Tightenco\Collect\Support\Collection;

abstract class BaseFactory
{
    public string $dtoClass = '';
    public string $dbClass = '';

    abstract protected function make(Generator $faker): array;

    /**
     * @param int $quantity
     * @param array $params
     * @return BaseTableDto|Collection
     * @throws Exception
     */
    public function factory(int $quantity = 1, array $params = []): BaseTableDto|Collection
    {
        $faker = Factory::create();
        $factoryFake = $this->make($faker);
        foreach ($params as $param => $paramValue) {
            $factoryFake[$param] = $paramValue;
        }
        $dto = $this
            ->getDto()
            ->attachValues($factoryFake);
        $allFactories = [];

        if($quantity === 1) {
            return $this->getDb()->insert($dto);
        }
        for($i = 0; $i < $quantity; $i++) {
            $allFactories[] = $this->getDb()->insert($dto);
        }

        return collect($allFactories);
    }

    /**
     * @throws Exception
     */
    private function getDto(): BaseTableDto
    {
        if (empty($this->dtoClass)) {
            throw new Exception('por favor implemente o atributo $dtoClass');
        }

        return new $this->dtoClass();
    }

    /**
     * @throws Exception
     */
    private function getDb(): BaseDb
    {
        if (empty($this->dbClass)) {
            throw new Exception('por favor implemente o atributo $dbClass');
        }

        return new $this->dbClass();
    }
}