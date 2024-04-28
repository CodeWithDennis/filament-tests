<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\RelationManager\Table\Summary;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;
use Filament\Tables\Columns\IconColumn;

class CountIcon extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can count the occurrence of icons in a column on the '.str($this->relationManager)->basename()->snake()->replace('_', ' ').' on the edit page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->getRelationManagerTableColumnsWithSummarizers($this->relationManager)
            ->filter(fn ($column) => collect($column->getSummarizers())->filter(function ($summarizer) use ($column) {
                return $summarizer::class === \Filament\Tables\Columns\Summarizers\Count::class &&
                    $column::class === IconColumn::class;
            })->count())->isNotEmpty();
    }
}
