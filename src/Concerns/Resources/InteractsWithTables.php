<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

trait InteractsWithTables
{
    use InteractsWithTableActions;
    use InteractsWithTableColumns;

    public function getResourceTable()
    {
        return $this->getResource()->table(new Table(
            app('livewire')->new(ListRecords::class)
        ));
    }
}
