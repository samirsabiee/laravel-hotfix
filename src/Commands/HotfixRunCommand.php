<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixRunCommand extends Command
{
    public $signature = 'hotfix:make { name : Hotfix class name}';

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
