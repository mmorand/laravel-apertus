<?php

namespace Mmorand\Apertus\Commands;

use Illuminate\Console\Command;

class ApertusCommand extends Command
{
    public $signature = 'apertus:models';

    public $description = 'List all available models from Apertus API';

    public function handle(): int
    {
        $models = app('apertus')->models()->list()->dto();
        $this->info('Available models:');
        foreach ($models->data as $model) {
            $this->line('- '.$model->id.' ('.$model->object.')');
        }

        return self::SUCCESS;
    }
}
