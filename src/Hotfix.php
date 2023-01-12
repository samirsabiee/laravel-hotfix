<?php

namespace SamirSabiee\Hotfix;

use Exception;
use Illuminate\Support\Facades\DB;
use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;

abstract class Hotfix implements IHotfix
{
    protected bool $transaction;

    public function __construct()
    {
        $this->transaction = config('hotfix.database.transaction');
    }

    abstract function handle();

    public function run()
    {
        try {
            if ($this->transaction) {
                $this->runWithTransaction();
            } else {
                $this->handle();
            }
            HotfixModel::query()->updateOrCreate([
                'name' => static::class
            ], [
                'name' => static::class,
                'error' => null
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            HotfixModel::query()->updateOrCreate([
                'name' => static::class
            ], [
                'name' => static::class,
                'error' => $e
            ]);
        }
    }

    public function runWithTransaction()
    {
        DB::beginTransaction();
        $this->handle();
        DB::commit();
    }

}
