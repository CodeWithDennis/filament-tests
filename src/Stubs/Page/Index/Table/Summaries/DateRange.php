<?php

namespace CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Summaries;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;
use ReflectionClass;

class DateRange extends Base
{
    public Closure|bool $isTodo = true;

    public function getShouldGenerate(): bool
    {
        return $this->getResourceTableColumnsWithSummarizers($this->resource)
            ->filter(fn ($column) => collect($column->getSummarizers())->filter(function ($summarizer) use ($column) {
                $reflectionProperty = (new ReflectionClass(get_class($column)))
                    ->getProperty('isDate');

                return $summarizer::class === \Filament\Tables\Columns\Summarizers\Range::class &&
                    $reflectionProperty->getValue($column);
            })->count())->isNotEmpty();
    }
}
