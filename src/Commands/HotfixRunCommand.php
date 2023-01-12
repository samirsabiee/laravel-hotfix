<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixRunCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:run { name : Hotfix class name}';

    public $description = 'Run Single Hotfix By Name';

    public function handle()
    {
        try {
            //todo
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
