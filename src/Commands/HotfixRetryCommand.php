<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\StubManager;

class HotfixRetryCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:retry { name : Hotfix class name Or Id}';

    public $description = 'retry hotfix or all hotfixes they have error in last runs';

    public function handle()
    {
        if ($this->argument('name') == 'all') {
            $files = glob(app_path('Hotfixes/' . config('hotfix.path')));

            if (count($files) == 0) {
                echo "\033[34m" . 'No hotfix found check your config path or be sure you have hotfix in app/Hotfixes folder and it\'s subFolders' . " \033 \r\n";
                return;
            }

            $files = collect($files)->map(function ($file) {
                return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
            })->toArray();

            $files = $this->hotfixRepository->getExecutedWithError($files);
        } elseif (is_numeric($this->argument('name'))) {
            $files = $this->hotfixRepository->findByIdWithError($this->argument('name'), ['name']);
            if (count($files) == 0) {
                echo "\033[34m" . 'Hotfix with ' . $this->argument('name') . 'ID not executed or executed with no error' . " \033 \r\n";
                return;
            }
        } else {
            $this->error('Invalid Option');
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
