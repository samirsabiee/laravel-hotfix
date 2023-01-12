<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixMakeCommand extends Command
{
    public $signature = 'hotfix:make { name : Hotfix class name}';

    public $description = 'Make Hotfix Stub File';

    public function handle()
    {
        try {
            $outputFile = (new StubManager())
                ->setName($this->argument('name'))->create();
            $this->info('File Created At ' . $outputFile);
        } catch (\Error|\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
