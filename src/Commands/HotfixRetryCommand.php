<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixRetryCommand extends Command
{
    public $signature = 'hotfix:retry { name : Hotfix class name}';

    public $description = 'retry hotfix or all hotfixes they have error in last run';

    public function handle()
    {
        try {
            //todo
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
