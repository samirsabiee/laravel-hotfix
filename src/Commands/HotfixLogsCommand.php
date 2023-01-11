<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixLogsCommand extends Command
{
    public $signature = 'hotfix:logs { name : Hotfix class name}';

    public $description = 'Show log hotfix file by name';

    public function handle()
    {
        try {
            //todo
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
