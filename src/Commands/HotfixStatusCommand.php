<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\StubManager;

class HotfixStatusCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:status { name : Hotfix class name}';

    public $description = 'Show Hotfix execution Status (Failed Or Success) By Still Unknown';

    public function handle()
    {
        try {
            $name = $this->argument('name');
            $nameParts = explode('/', $name);
            $name = last($nameParts);
            array_pop($nameParts);
            $subFolders = implode('/', $nameParts);
            $subFolders .= empty($subFolders) ? '' : '/';
            $files = glob(app_path('Hotfixes/' . $subFolders . str_replace('.php', '', config('hotfix.path')) . $name . '*.php'));
            if (count($files) == 0) {
                $this->info('No file founded');
                return;
            }

            $files = collect($files)->map(function ($file) {
                return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
            })->toArray();

            if (count($files) > 1) {
                $counter = 0;
                foreach ($files as $file){
                    $tableData[] = [$counter++, $file];
                }
                $this->table(['NUMBER', 'NAME'], $tableData);
                $index = $this->ask('Which One?');
                $files = $tableData[$index];
                array_shift($files);
            }

            foreach ($files as $file) {
                try {
                    dd($this->hotfixRepository->findBy('name', $file));
                    $hotfix = $this->hotfixRepository->findBy('name', $file)->toArray();
                } catch (\Error|\Exception $e) {
                    echo "\033[31m \xE2\x9D\x8C " . $file . " \033 \r\n";
                }
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
