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

    public function ls(array $hotfixes, $justExecutedWithError = false, $limit = null): array
    {
        $query = $this->model->query()->whereIn('name', $hotfixes)->orderByDesc('id')
            ->selectRaw('id, name, error::json->>\'message\' as error');
        if ($justExecutedWithError) {
            $query->whereNotNull('error');
        }
        if (isset($limit) && !is_null($limit)) {
            $query->limit($limit);
        }
        return $query->get()->toArray();
    }

    public function findById(string $id, $columns = ['*']): array
    {
        return $this->model->query()->where('id', $id)->firstOrFail($columns)->toArray();
    }

    public function findByIdWithError(string $id, $columns = ['id', 'name', 'error']): array
    {
        $hotfix = $this->model->query()->whereNotNull('error')->where('id', $id)->first($columns);
        if (is_null($hotfix)) {
            return [];
        }
        return $hotfix->toArray();

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

    public function findBy(string $column, $value)
    {
        return $this->model->query()->where($column, $value)->first();
    }

}
