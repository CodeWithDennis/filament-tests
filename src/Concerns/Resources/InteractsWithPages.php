<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\PageRegistration;
use Illuminate\Support\Collection;

trait InteractsWithPages
{
    public function getPages(): array
    {
        return $this->getResource()::getPages();
    }

    public function hasPages(array $pages): bool
    {
        return array_diff($pages, array_keys($this->getPages())) === [];
    }

    public function getPage(string $page): ?PageRegistration
    {
        $pages = $this->getPages();

        return $pages[$page] ?? null;
    }

    public function hasPage(string $page): bool
    {
        return $this->hasPages([$page]);
    }

    public function getPageHeaderAction(string $page, string $action, bool $withDummyModel = false)
    {
        return collect($this->getPageHeaderActions($page))
            ->first(fn (Action $flatAction): bool => $flatAction
                ->when(fn (): bool => $withDummyModel, fn (Action $action): \Filament\Actions\Action => $action->record(new ($this->getResourceModel())))
                ->getName() === $action);
    }

    public function getPageHeaderActions(string $page): array
    {
        $page = $this->getPage($page)->getPage();
        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getHeaderActions');

        $method->setAccessible(true);

        $actions = $method->invoke(app($page));
        $flatActions = [];

        /* We need to flatten the actions because they can be grouped inside ActionGroup */
        foreach ($actions as $action) {
            if ($action instanceof Action) {
                $flatActions[] = $action;
            } elseif ($action instanceof ActionGroup) {
                $flatActions = [...$flatActions, ...$action->getActions()];
            }
        }

        return $flatActions;
    }

    public function getPageClass(string $page): ?string
    {
        if (! $this->hasPage($page)) {
            return null;
        }

        if (is_null($this->getPage($page))) {
            return null;
        }

        try {
            $pageRegistry = $this->getPage($page);

            $reflection = new \ReflectionClass($pageRegistry);

            $property = $reflection->getProperty('page');

            return $property->getValue($pageRegistry);

        } catch (\ReflectionException) {
            return null;
        }
    }

    public function getPageHeaderVisibleActions(string $page): Collection
    {
        // TODO: maybe setting this on getPageHeaderActions instead?! 🤔
        return collect($this->getPageHeaderActions($page))
            ->filter(function (Action $action): bool {

                $model = $this->getResourceModel();

                $action->record(new $model);

                return $action->isVisible();
            });
    }

    public function getPageHeaderHiddenActions(string $page): Collection
    {
        // TODO: maybe setting this on getPageHeaderActions instead?! 🤔
        return collect($this->getPageHeaderActions($page))
            ->filter(function (Action $action): bool {

                $model = $this->getResourceModel();

                $action->record(new $model);

                return $action->isHidden();
            });
    }
}
