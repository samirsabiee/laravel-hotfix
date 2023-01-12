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

    public function getNotExecutedHotfixes(array $hotfixes): array
    {
        $dbHotfixes = $this->model->query()->whereIn('name', $hotfixes)->pluck('name')->toArray();
        return array_diff($hotfixes, $dbHotfixes);
    }

    public function ls(int $count = 10): array
    {
        return $this->model->query()->orderByDesc('id')->limit($count)->get(['id', 'name'])->toArray();
    }

    public function findById(string $id, $columns = ['id', 'name', 'error']): array
    {
        return $this->model->query()->where('id', $id)->get($columns)->toArray();
    }

    public function prune(array $hotfixes): void
    {
        $this->model->query()->whereNotIn('name', $hotfixes)->delete();
    }

    public function getExecutedWithError(array $hotfixes): array
    {
        return $this->model->query()->whereIn('name', $hotfixes)
            ->whereNotNull('error')
            ->pluck('name')->toArray();
    }

}
