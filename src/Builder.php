<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder;

use Compolomus\LSQLQueryBuilder\{
    System\Traits\Helper,
    System\Traits\Magic,
    Parts\Insert,
    Parts\Select,
    Parts\Update,
    Parts\Delete,
    Parts\Count
};

/**
 * @method Insert insert(array $args)
 * @method Select select(array $fields)
 * @method Update update(array $args)
 * @method Delete delete(integer $id)
 * @method Count count(string $field, string|null $alias)
 */
class Builder
{
    use Magic, Helper;

    private $table;

    private $placeholders = [];

    public function __construct(string $table)
    {
        if ($table) {
            $this->setTable($table);
        }
    }

    private function setTable(string $table): Builder
    {
        $this->table = $table;
        return $this;
    }

    public function table(): string
    {
        return $this->escapeField($this->table);
    }

    public function placeholders(): array
    {
        return $this->placeholders;
    }

    public function addPlaceholders($placeholders): void
    {
        $this->placeholders = $this->placeholders + $placeholders;
    }
}
