<?php

namespace SamirSabiee\Hotfix;

use Illuminate\Support\Facades\DB;
use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;

abstract class Hotfix implements IHotfix
{
    protected bool $transaction;
    private HotfixRepository $hotfixRepository;

    public function __construct(HotfixRepository $hotfixRepository)
    {
        $this->transaction = config('hotfix.database.transaction');
        $this->hotfixRepository = $hotfixRepository;
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
            $this->hotfixRepository->updateOrCreate(static::class);
        } catch (\Error $e) {
            DB::rollBack();
            $this->hotfixRepository->updateOrCreate(static::class, $e);
        }
    }

    public function runWithTransaction()
    {
        DB::beginTransaction();
        $this->handle();
        DB::commit();
    }

}
