<?php

namespace SamirSabiee\Hotfix\Commands;

use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;

abstract class HotfixBaseCommand extends Command
{
    protected HotfixRepository $hotfixRepository;

    public function __construct()
    {
        parent::__construct();
        $this->hotfixRepository = resolve(HotfixRepository::class);
    }

    public function getFiles(): bool|array
    {
        return glob(app_path('Hotfixes/'.config('hotfix.path')));
    }
}
