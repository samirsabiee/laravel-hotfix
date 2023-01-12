<?php

namespace SamirSabiee\Hotfix\Commands;

use Illuminate\Console\Command;
use PhpParser\Error;
use SamirSabiee\Hotfix\Hotfix;
use SamirSabiee\Hotfix\Models\Hotfix as HotfixModel;
use SamirSabiee\Hotfix\StubManager;

class HotfixCommand extends Command
{
    public $signature = 'hotfix { last : execute nth last hotfix default is one}';

    public $description = 'Run new hotfix files';

    public function handle()
    {
        try {
            $files = glob(app_path('Hotfixes/' . config('hotfix.path')));

            if(count($files) == 0) {
                $this->line('No hotfix found check your config path or be sure you have hotfix in app/Hotfixes folder and it\'s subFolders');
            }

            foreach (array_slice($files, $this->argument('last') * -1) as $file) {
                /** @var Hotfix $hotfix */
                $hotfix = resolve("App\\Hotfixes" . str_replace('/', '\\', last(array_reverse(explode('.php', last(explode('app/Hotfixes', $file)))))));
                $hotfix->run();
            }
        } catch (\ParseError | Error | \Exception $e) {
            HotfixModel::query()->updateOrCreate([
                'name' => static::class
            ], [
                'name' => static::class,
                'error' => $e
            ]);
        }
    }
}
