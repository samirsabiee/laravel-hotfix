<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\StubManager;

class HotfixLsCommand extends Command
{
    public $signature = 'hotfix ls { count? : the nth last hotfix}';

    public $description = 'Show info of hot fix';

    public function handle()
    {
        try {
            $this->table(['ID', 'NAME'], resolve(HotfixRepository::class)->ls($this->argument('count')));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
