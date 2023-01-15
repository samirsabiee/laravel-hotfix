<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use SamirSabiee\Hotfix\Hotfix;

class HotfixRunCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:run { name : Hotfix class ID}';

    public $description = 'Run Single Hotfix By Name';

    public function handle()
    {
        try {
            $name = $this->argument('name');
            $nameParts = explode('/', $name);
            $name = last($nameParts);
            array_pop($nameParts);
            $subFolders = implode('/', $nameParts);
            $subFolders .= empty($subFolders) ? '' : '/';
            $files = glob(app_path('Hotfixes/'.$subFolders.str_replace('.php', '', config('hotfix.path')).$name.'*.php'));
            if (count($files) == 0) {
                $this->info('No file founded');

                return;
            }

            $files = collect($files)->map(function ($file) {
                return 'App\\Hotfixes'.str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
            })->toArray();

            if (count($files) > 1) {
                $counter = 0;
                foreach ($files as $file) {
                    $tableData[] = [$counter++, $file];
                }
                $this->table(['NUMBER', 'NAME'], $tableData);
                $index = $this->ask('Which One?');
                $files = $tableData[$index];
                array_shift($files);
            }

            foreach ($files as $file) {
                try {
                    /** @var Hotfix $hotfix */
                    $hotfix = resolve($file);
                    $hotfix->run();
                } catch (\Error|\Exception $e) {
                    echo "\033[31m \xE2\x9D\x8C ".$file." \033 \r\n";
                    $this->hotfixRepository->updateOrCreate($file, $e);
                }
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
