<?php

namespace CodeWithDennis\FilamentTests\Concerns\Resources\Pages;

trait InteractsWithIndexPage
{
    public function hasIndexPage(): bool
    {
        return $this->hasPage('index');
    }

    public function getIndexPageClass(): ?string
    {
        if (! $this->hasPage('index')) {
            return null;
        }

        if (is_null($this->getPage('index'))) {
            return null;
        }

        try {
            $indexPage = $this->getPage('index');

            $reflection = new \ReflectionClass($indexPage);
            $property = $reflection->getProperty('page');

            return $property->getValue($indexPage);

        } catch (\ReflectionException) {
            return null;
        }
    }
}
