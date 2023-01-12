<?php

namespace SamirSabiee\Hotfix\Commands;

use Illuminate\Console\Command;
use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;
use SamirSabiee\Hotfix\StubManager;

class HotfixCommand extends Command
{
    public $signature = 'hotfix { last : execute nth last hotfix}';

    public $description = 'Run new hotfix files';

    public function handle()
    {
        /** @var HotfixRepository $hotfixRepository */
        $hotfixRepository = resolve(HotfixRepository::class);
        $files = glob(app_path('Hotfixes/' . config('hotfix.path')));

        if (count($files) == 0) {
            $this->line('No hotfix found check your config path or be sure you have hotfix in app/Hotfixes folder and it\'s subFolders');
            return;
        }
        $files = collect(array_slice($files, $this->argument('last') * -1))->map(function ($file) {
            return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
        })->toArray();

        $files = $hotfixRepository->getNotRunedHotfixes($files);

        foreach ($files as $file) {
            try {
                /** @var Hotfix $hotfix */
                $hotfix = resolve($file);
                $hotfix->run();
            } catch (\Error|\Exception $e) {
                echo "\033[31m \xE2\x9D\x8C " . $file . " \033 \r\n";
                $hotfixRepository->updateOrCreate($file, $e);
            }
        }
    }
}
