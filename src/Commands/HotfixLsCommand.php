<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\StubManager;

class HotfixLsCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:ls { count? : the nth last hotfix}';

    public $description = 'Show info of hot fix';

    public function handle()
    {
        try {
            $count = $this->argument('count');
            $this->table(['ID', 'NAME', 'ERROR'], $this->hotfixRepository->ls(is_null($count) ? 10 : $count));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
