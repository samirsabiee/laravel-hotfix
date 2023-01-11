<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\StubManager;

class HotfixCommand extends Command
{
    public $signature = 'hotfix';

    public $description = 'Run new hotfix files';

    public function handle()
    {
        try {
            $files = glob(app_path('Hotfixes/' . config('hotfix.path')));
            foreach ($files as $file) {
                /** @var Hotfix $hotfix */
                $hotfix = resolve("App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file)))))));
                $hotfix->run();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
