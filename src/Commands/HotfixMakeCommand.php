<?php

namespace SamirSabiee\Hotfix\Commands;

use SamirSabiee\Hotfix\StubManager;

class HotfixMakeCommand extends HotfixBaseCommand
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
