<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources;

trait InteractsWithPages
{
    public function getPages(): array
    {
        return $this->getResource()::getPages();
    }

    public function hasPages(array $pages): bool
    {
        return empty(array_diff($pages, array_keys($this->getPages())));
    }

    public function hasPage(string $page): bool
    {
        return $this->hasPages([$page]);
    }
}
