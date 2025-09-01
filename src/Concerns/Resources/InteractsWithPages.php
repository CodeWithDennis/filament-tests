<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use Filament\Resources\Pages\PageRegistration;

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
}
