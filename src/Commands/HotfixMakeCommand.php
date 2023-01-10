<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\StubManager;

class HotfixMakeCommand extends Command
{
    public $signature = 'hotfix:make
                        { name : Hotfix class name}
                        { path? : Where to be created? default path is app/Hotfixes}
                        { --f|force? : Overwrite existing files without confirmation}
                        ';

    public $description = 'Make Hotfix Stub File';

    public function handle()
    {
        try {
            $outputFile = (new StubManager())
                ->setName($this->argument('name'))
                ->setPath($this->argument('path'))
                ->create($this->option('force'));
            $this->info('File Created At ' . $outputFile);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
