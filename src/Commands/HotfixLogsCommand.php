<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\StubManager;

class HotfixLogsCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:logs { id : Hotfix ID}';

    public $description = 'Show log hotfix file by ID';

    public function handle()
    {
        try {
            $this->table(['ID', 'NAME', 'ERROR'], $this->hotfixRepository
                ->findById($this->argument('id')));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
