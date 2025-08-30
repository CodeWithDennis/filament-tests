<?php

namespace CodeWithDennis\FilamentTests\TestRenderers;

class CanRenderEditPageTest extends BaseTest
{
    public function render(): string
    {
        return view('filament-tests::can-render-edit-page', [
            'resourceClass' => $this->getResourceClass(),
        ])->render();
    }
}
