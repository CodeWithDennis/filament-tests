<?php

namespace CodeWithDennis\FilamentTests\Concerns\Commands;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;

trait InteractsWithUserInput
{
    protected function getSelectedPanels(): Collection
    {
        return $this->panels ??= collect();
    }

    protected function getSelectedResources(): Collection
    {
        return $this->resources ??= collect();
    }

    protected function askUserToSelectPanels(): Collection
    {
        $allPanels = collect(Filament::getPanels());

        if ($allPanels->count() === 1) {
            return collect([$allPanels->first()->getId()]);
        }

        $options = $allPanels->mapWithKeys(fn (Panel $panel) => [$panel->getId() => $panel->getId()])->toArray();

        return collect(multiselect(
            label: 'Which Filament panel/s do you want to generate tests for?',
            options: $options,
            required: true,
            hint: 'You can select multiple panels',
        ));
    }

    protected function askUserToSelectResourcesFromTheSelectedPanels(): Collection
    {
        $selectedResources = collect();

        foreach ($this->getSelectedPanels() as $panelId) {
            $resources = collect(Filament::getPanel($panelId)?->getResources() ?? [])
                ->mapWithKeys(fn (string $resource) => [$resource => class_basename($resource)])
                ->toArray();

            if (empty($resources)) {
                continue;
            }

            $selected = multiselect(
                label: "Select resources for panel: {$panelId}",
                options: $resources,
                required: true,
            );

            if ($selected !== []) {
                $selectedResources[$panelId] = $selected;
            }
        }

        return $selectedResources;
    }
}
