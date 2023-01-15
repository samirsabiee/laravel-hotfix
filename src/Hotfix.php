<?php

namespace SamirSabiee\Hotfix;

use Illuminate\Support\Facades\DB;

abstract class Hotfix implements IHotfix
{
    protected bool $dbTransaction;
    private HotfixRepository $hotfixRepository;

    public function __construct(HotfixRepository $hotfixRepository)
    {
        if (!isset($this->dbTransaction)) {
            $this->dbTransaction = config('hotfix.database.transaction');
        }
        $this->hotfixRepository = $hotfixRepository;
    }

    abstract function handle();

    public function run()
    {
        try {
            if ($this->dbTransaction) {
                $this->runWithTransaction();
            } else {
                $this->handle();
            }
            $this->hotfixRepository->updateOrCreate(static::class);
            echo "\033[32m \xE2\x9C\x94 " . static::class . " \033 \r\n";
        } catch (\Error|\Exception $e) {
            DB::rollBack();
            $this->hotfixRepository->updateOrCreate(static::class, $e);
            echo "\033[31m \xE2\x9D\x8C " . static::class . " \033 \r\n";
        }
    }

    public function runWithTransaction()
    {
        DB::beginTransaction();
        $this->handle();
        DB::commit();
    }

}
