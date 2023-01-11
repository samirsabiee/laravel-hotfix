<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixCommand extends Command
{
    public $signature = 'hotfix';

    public $description = 'Run new hotfix files';

    public function handle()
    {
        try {
            $files = glob(app_path('Hotfixes/' . config('hotfix.path')));
            dd($files);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
