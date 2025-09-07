<?php

namespace CodeWithDennis\FilamentTests\Concerns;

use CodeWithDennis\FilamentTests\Exceptions\GlobalConfiguredUsingCouldNotBeDeterminedException;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Table;

trait InteractsWithServiceProviders
{
    use EvaluatesClosures;

    public function getGloballyConfiguredUsing(string $class): object
    {
        return match ($class) {
            Table::class => Table::make(app('livewire')->new(ListRecords::class)),
            is_subclass_of($class, Entry::class, true),
            is_subclass_of($class, Field::class, true) => $class::make('dummy-name'), // some components require a name in their constructor
            method_exists($class, 'make') => $class::make(),
            default => throw new GlobalConfiguredUsingCouldNotBeDeterminedException($class, 'make() method')
        };
    }
}
