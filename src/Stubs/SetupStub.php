<?php

namespace CodeWithDennis\FilamentTests\Stubs;

class SetupStub extends Base
{
    public string $name = 'Setup';

    public function getVariables(): array
    {
        $resource = $this->resource;

        $resourceModel = $resource->getModel();
        $userModel = \App\Models\User::class;
        $modelImport = $resourceModel === $userModel ? "use {$resourceModel};" : "use {$resourceModel};\nuse {$userModel};";

        $toBeConverted = [
            'MODEL_IMPORT' => $modelImport,
            'MODEL_PLURAL_NAME' => str($resourceModel)->afterLast('\\')->plural(),
            'MODEL_SINGULAR_NAME' => str($resourceModel)->afterLast('\\'),
            'RESOURCE' => str($resource::class)->afterLast('\\'),
            'LOAD_TABLE_METHOD_IF_DEFERRED' => $this->tableHasDeferredLoading($resource) ? $this->getDeferredLoadingMethod() : '',
        ];

        $converted = array_map(function ($value) {
            return $this->convertDoubleQuotedArrayString($value);
        }, $toBeConverted);

        return array_merge($converted, $toBeConverted);
    }
}
