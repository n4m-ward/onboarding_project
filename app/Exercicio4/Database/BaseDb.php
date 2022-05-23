<?php

namespace Onboarding\Exercicio4\Database;

use Exception;
use Onboarding\Exercicio4\Database\Factories\BaseFactory;
use Onboarding\Exercicio4\Dto\BaseTableDto;
use Onboarding\Exercicio4\Dto\CartDto;
use Onboarding\Exercicio4\Dto\ProductDto;
use Onboarding\Exercicio4\Dto\UserDto;
use Onboarding\Exercicio4\Dto\WhereDto;
use Onboarding\Exercicio4\Interfaces\DbInterface;
use Tightenco\Collect\Support\Collection;

class BaseDb implements DbInterface
{
    public const FILE_SULFIX = '.json';
    public string $table = '';
    public string $dtoClass = '';
    public string $factoryClass = '';

    /**
     * @var array<WhereDto>
     */
    public array $wheres;

    /**
     * @return Collection<BaseTableDto>
     */
    public function getAll(): Collection
    {
        $modelPath = $this->getModelPath();
        $tableContentJson = (string) file_get_contents($modelPath);
        $tableContentArray = json_decode($tableContentJson, true);

        return collect($tableContentArray)
            ->transform(function (array $arrayItem) {
                return $this->getDto()
                    ->attachValues($arrayItem);
            });
    }

    /**
     * @throws Exception
     */
    public function insert(BaseTableDto $tableDto): BaseTableDto
    {
        $this->checkCorrectDto($tableDto);
        $tableDto->attachValues(['id' => $this->getNewId()]);
        $collectionWithNewData = self::getAll()
            ->push($tableDto);

        $this->saveContent($collectionWithNewData);

        return $tableDto;
    }

    /**
     * @throws Exception
     */
    public function update(BaseTableDto $tableDto): BaseTableDto
    {
        $this->checkCorrectDto($tableDto);
        $this->checkWheres();
        $allItems = $this->getAll();
        $itemToUpdate = $this->getSingleItemByWheres();
        $itemId = $itemToUpdate->id;
        $tableDto->attachValues(['id' => $itemId]);
        $allItemUpdated = $allItems->transform(function (BaseTableDto $item) use ($tableDto) {
            if ($item->id === $tableDto->id) {
                return $tableDto;
            }

            return $item;
        });
        $this->saveContent($allItemUpdated);
        $this->clearWheres();

        return $tableDto;
    }

    /**
     * @throws Exception
     */
    public function delete(): void
    {
        $this->checkWheres();
        $allItems = $this->getAll();
        $itemToUpdate = $this->getSingleItemByWheres();
        $itemId = $itemToUpdate->id;
        $allItemUpdated = $allItems->filter(function (BaseTableDto $item) use ($itemId) {
            return $item->id != $itemId;
        });
        $this->clearWheres();
        $this->saveContent($allItemUpdated);
    }

    private function getSingleItemByWheres(): BaseTableDto
    {
        $itemToUpdate = $this->getAll();
        foreach ($this->wheres as $where) {
            $itemToUpdate = $itemToUpdate->where($where->column, $where->symbol, $where->value);
        }

        return $itemToUpdate->first();
    }

    private function saveContent(Collection $content): void
    {
        $contentJson = (string) json_encode($content);
        $model = $this->getModelPath();

        $fp = fopen($model, "w+");

        fwrite($fp, $contentJson);
        fclose($fp);
    }

    private function getModelPath(): string
    {
        return __DIR__ . '/Models/' . $this->table . self::FILE_SULFIX;
    }

    private function getDto(): BaseTableDto
    {
        return new $this->dtoClass();
    }

    private function getNewId(): int
    {
        $contentId = $this->getAll()
                ->sortByDesc('id')
                ->first()
                ->id ?? null;

        return is_null($contentId)
            ? 1
            : $contentId + 1;
    }

    public function where(string $column, string $symbol, string|int|bool $value): static
    {
        $whereDto = new WhereDto();
        $whereDto->attachValues([
            'column' => $column,
            'symbol' => $symbol,
            'value' => $value,
        ]);
        $this->wheres[] = $whereDto;

        return $this;
    }

    /**
     * @param BaseTableDto $dto
     * @return void
     * @throws Exception
     */
    private function checkCorrectDto(BaseTableDto $dto): void
    {
        $dtoClass = get_class($dto);
        $isCorrectDto = $dtoClass === $this->dtoClass;

        if (!$isCorrectDto) {
            throw new Exception("Por favor use o dto: {$this->dtoClass}");
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function checkWheres(): void
    {
        if (empty($this->wheres)) {
            throw new Exception("impossivel usar a clausula sem antes usar where");
        }
    }

    private function clearWheres(): void
    {
        $this->wheres = [];
    }

    /**
     * @param int $quantity
     * @param array<mixed> $params
     * @return Collection|ProductDto|CartDto|UserDto
     * @throws Exception
     */
    public function factory(int $quantity = 1, array $params = []): Collection|ProductDto|CartDto|UserDto
    {
        return $this->getFactoryInstance()
            ->factory($quantity, $params);
    }

    /**
     * @throws Exception
     */
    private function getFactoryInstance(): BaseFactory
    {
        if (empty($this->factoryClass)) {
            throw new Exception('essa classe não possui uma factory');
        }

        return new $this->factoryClass();
    }
}
