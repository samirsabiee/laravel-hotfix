<?php

namespace SamirSabiee\Hotfix;

use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;

class HotfixRepository
{
    private HotfixModel $model;

    public function __construct(HotfixModel $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate(string $name, \Error|\Exception $e = null): void
    {
        $this->model->query()->updateOrCreate([
            'name' => $name
        ], [
            'name' => $name,
            'error' => is_null($e) ? null : json_encode([
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            ])
        ]);
    }

    public function getNotRunedHotfixes(array $hotfixes)
    {
        $dbHotfixes = $this->model->query()->whereIn('name', $hotfixes)->pluck('name')->toArray();
        return array_diff($hotfixes, $dbHotfixes);
    }

}
