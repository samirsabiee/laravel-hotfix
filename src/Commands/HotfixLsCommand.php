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

            if (!is_null($this->argument('count')) && is_numeric($this->argument('count'))) {
                $files = array_slice($files, $this->argument('last') * -1);
            } else {
                $files = array_slice($files, -10);
            }

            $fromDbFiles = $this->hotfixRepository->ls($files, $this->option('error') == true);

            if ($this->option('error')) {
                $filesReadyToTable = collect($fromDbFiles)->map(function ($dbFile) {
                    $dbFile['STATUS'] = 'FAILED';
                    return $dbFile;
                })->toArray();
            } else {
                $filesReadyToTable = collect($files)->map(function ($file) use($fromDbFiles) {
                    $dbFile = collect($fromDbFiles)->where('name', $file)->first();
                    if(is_null($dbFile)){
                        return [
                            'id' => null,
                            'name' => $file,
                            'error' => null,
                            'status' => 'NOT EXECUTED',
                        ];
                    }
                    $dbFile['status'] = is_null($dbFile['error']) ? 'SUCCESS' : 'FAILED';
                    return $dbFile;
                })->toArray();
            }
            $this->table(['ID', 'NAME', 'ERROR', 'STATUS'], $filesReadyToTable);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
