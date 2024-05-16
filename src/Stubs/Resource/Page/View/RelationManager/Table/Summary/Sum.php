<?php

namespace CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\RelationManager\Table\Summary;

use Closure;
use CodeWithDennis\FilamentTests\Stubs\Base;

class Sum extends Base
{
    public Closure|bool $isTodo = true;

    public function getDescription(): string
    {
        return 'can sum values in a column on the '.str($this->getRelationManager($this->relationManager)->getRelationshipName())->lcfirst().' relation manager on the view page';
    }

    public function getShouldGenerate(): bool
    {
        return $this->hasPage('view', $this->resource)
            && $this->getRelationManagerTableColumnsWithSummarizers($this->relationManager)
                ->filter(fn ($column) => collect($column->getSummarizers())
                    ->filter(fn ($summarizer) => $summarizer::class === \Filament\Tables\Columns\Summarizers\Sum::class)
                    ->count())
                ->isNotEmpty();
    }
}
