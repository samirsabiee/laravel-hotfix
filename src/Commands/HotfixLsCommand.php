<?php

namespace SamirSabiee\Hotfix\Commands;

use Exception;
use Illuminate\Console\Command;
use SamirSabiee\Hotfix\HotfixRepository;
use SamirSabiee\Hotfix\StubManager;

class HotfixLsCommand extends HotfixBaseCommand
{
    public $signature = 'hotfix:ls
                        { count? : the nth last hotfix}
                        {--error : when is true just hotfixes executed with error will be shown}';

    public $description = 'Show info of hotfix';

    public function handle()
    {
        try {
            $count = $this->argument('count');

            $files = $this->getFiles();

            if (count($files) == 0) {
                echo "\033[34m" . 'No hotfix found check your config path or be sure you have hotfix in app/Hotfixes folder and it\'s subFolders' . " \033 \r\n";
                return;
            }

            $files = collect($files)->map(function ($file) {
                return "App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file))))));
            })->toArray();

            if (!is_null($this->argument('last')) && is_numeric($this->argument('last'))) {
                $files = array_slice($files, $this->argument('last') * -1);
            } else {
                $files = array_slice($files, -10);
            }

            $fromDbFiles = $this->hotfixRepository->ls($files, $this->option('error') == true);

            if ($this->option('error')) {
                $fromDbFiles = collect($fromDbFiles)->map(fn($dbFile) => $dbFile['STATUS'] = 'EXECUTED');
                $this->table(['ID', 'NAME', 'ERROR', 'STATUS'], $fromDbFiles);
            } else {
                //TODO
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
