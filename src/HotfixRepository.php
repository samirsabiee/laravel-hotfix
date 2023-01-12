<?php

namespace SamirSabiee\Hotfix;

use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;

class HotfixRepository
{
    public function updateOrCreate(string $name, \Error $e = null): void
    {
        HotfixModel::query()->updateOrCreate([
            'name' => $name
        ], [
            'name' => $name,
            'error' =>  json_encode([
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ])
        ]);
    }

}
