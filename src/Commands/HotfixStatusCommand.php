<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixStatusCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:status { name : Hotfix class name}';

    public $description = 'Show Hotfix execution Status (Failed Or Success) By Still Unknown';

    public function handle()
    {
        try {
           //todo
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
