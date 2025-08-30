<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

class CanRenderCreatePageTest extends BaseTest
{
    public function render(): string
    {
        return view('filament-tests::can-render-create-page', [
            'resourceClass' => $this->getResourceClass(),
        ])->render();
    }
}
