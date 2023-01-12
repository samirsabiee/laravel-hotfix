<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixPruneCommand extends Command
{
    public $signature = 'hotfix:prune}';

    public $description = 'Sync Database With Files Exist On Path Storage';

    public function handle()
    {
        try {
            $outputFile = (new StubManager())
                ->setName($this->argument('name'))->create();
            $this->info('File Created At ' . $outputFile);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
