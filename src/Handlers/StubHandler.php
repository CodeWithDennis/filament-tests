<?php

namespace CodeWithDennis\FilamentTests\Handlers;

use Filament\Resources\Resource;
use Illuminate\Support\Collection;

class StubHandler
{
    public function __construct(public Resource $resource)
    {
    }

    public function setResource(?Resource $resource = null): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getStubs(): Collection
    {
        $resource = $this->resource;

        $stubs = [
            \CodeWithDennis\FilamentTests\Stubs\SetupStub::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Render::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\ListRecords::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\ListRecordsPaginated::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Trashed::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Actions\Exist::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Actions\Hidden::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Actions\Visible::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Heading::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Description::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\Url::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\UrlTab::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\Exist::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\Delete::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\DeleteSoft::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\Replicate::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\Restore::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Actions\DeleteForce::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkActions\Restore::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkActions\Delete::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkActions\DeleteForce::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkActions\DeleteSoft::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\BulkActions\Exist::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\Exist::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\Render::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\CannotRender::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\Sort::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\Search::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\SearchIndividually::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\DescriptionAbove::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\DescriptionBelow::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\Select::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Columns\ExtraAttributes::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\Average::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\Count::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\CountIcon::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\Range::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\DateRange::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Summaries\Sum::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Filters\Reset::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Filters\Add::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Index\Table\Filters\Remove::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Render::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields\Disabled::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields\Exists::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields\Hidden::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Fields\Validate::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Exists::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Create\Form\Validate::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Render::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields\Disabled::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields\Exists::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields\Hidden::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Fields\Validate::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Exists::make($resource ?? $this->resource)->get(),
            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\Edit\Form\Validate::make($resource ?? $this->resource)->get(),

            \CodeWithDennis\FilamentTests\Stubs\Resource\Page\View\Render::make($resource ?? $this->resource)->get(),
        ];

        return collect($stubs);
    }
}
