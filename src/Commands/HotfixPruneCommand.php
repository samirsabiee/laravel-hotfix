<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\StubManager;

class HotfixPruneCommand extends Command
{
    public $signature = 'hotfix:prune}';

    public $description = 'Sync Database With Files Exist On Path Storage';

    public function handle()
    {
        try {
            /** @var HotfixRepository $hotfixRepository */
            $hotfixRepository = resolve(HotfixRepository::class);
            $files = glob(app_path('Hotfixes/' . config('hotfix.path')));

            $files = collect($files)->map(function ($file) {
                return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
            })->toArray();

            $hotfixRepository->prune($files);

            $this->info('Database Synced With file on Storage');

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
