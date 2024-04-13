<?php

namespace CodeWithDennis\FilamentTests\Handlers;

use Filament\Resources\Resource;
use Illuminate\Support\Collection;

class StubHandler
{
    public function __construct(public Resource $resource)
    {
    }

    public function setResource(Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getStubs(): Collection
    {
        $resource = $this->resource;

        $stubs = [
            \CodeWithDennis\FilamentTests\Stubs\SetupStub::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Render::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\ListRecords::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\ListRecordsPaginated::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Trashed::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions\Exist::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions\Hidden::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Actions\Visible::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Heading::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Description::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\Url::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\UrlTab::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\Exist::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\Delete::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\DeleteSoft::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\Replicate::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\Restore::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Actions\DeleteForce::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions\Restore::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions\Delete::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\BulkActions\DeleteForce::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\Exist::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\Render::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\CannotRender::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\Sort::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\Search::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\SearchIndividually::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\DescriptionAbove::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\DescriptionBelow::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\Select::make($resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Columns\ExtraAttributes::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Index\Table\Filters\Reset::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Create\Render::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\Edit\Render::make($resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Page\View\Render::make($resource)->get(),

            ...$this->getTodoStubs(),
        ];

        return collect($stubs);
    }

    protected function getTodoStubs()
    {
        return collect(scandir(__DIR__.'/../Stubs'))
            ->filter(fn ($file) => str_ends_with($file, '.php'))
            ->map(fn ($file) => str_replace('.php', '', $file))
            ->map(fn ($file) => '\\CodeWithDennis\\FilamentTests\\Stubs\\'.$file)
            ->map(fn ($file) => new $file($this->resource))
            ->filter(fn ($file) => $file->isTodo())
            ->map(fn ($file) => $file->get());
    }
}
