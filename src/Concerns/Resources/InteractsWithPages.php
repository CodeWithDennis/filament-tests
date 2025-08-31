<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

use CodeWithDennis\FilamentTests\Concerns\Resources\Pages\InteractsWithIndexPage;
use Filament\Resources\Pages\PageRegistration;

trait InteractsWithPages
{
    use InteractsWithIndexPage;

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
}
