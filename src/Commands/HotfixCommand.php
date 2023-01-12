<?php

namespace SamirSabiee\Hotfix\Commands;

use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;
use SamirSabiee\Hotfix\StubManager;

class HotfixCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix { last : execute nth last hotfix}';

    public $description = 'Run new hotfix files';

    public function handle()
    {
        if (!is_numeric($this->argument('last')) && $this->argument('last') != 'all') {
            $this->error('Invalid Options');
            return;
        }

        $files = glob(app_path('Hotfixes/' . config('hotfix.path')));

        if (count($files) == 0) {
            echo "\033[34m" . 'No hotfix found check your config path or be sure you have hotfix in app/Hotfixes folder and it\'s subFolders' . " \033 \r\n";
            return;
        }

        if ($this->argument('last') != 'all') {
            $files = array_slice($files, $this->argument('last') * -1);
        }

        $files = collect($files)->map(function ($file) {
            return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
        })->toArray();

        $files = $this->hotfixRepository->getNotExecutedHotfixes($files);

        if (count($files) == 0) {
            echo "\033[34m" . 'The last ' . $this->argument('last') . ' files have been executed. There is nothing to execute' . " \033 \r\n";
            return;
        }

        foreach ($files as $file) {
            try {
                /** @var Hotfix $hotfix */
                $hotfix = resolve($file);
                $hotfix->run();
            } catch (\Error|\Exception $e) {
                echo "\033[31m \xE2\x9D\x8C " . $file . " \033 \r\n";
                $this->hotfixRepository->updateOrCreate($file, $e);
            }
        }
    }
}
