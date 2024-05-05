<?php

namespace TaliumAttributes\console;

use Illuminate\Console\Command;

class PushControllerList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'router-attribute:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes the controller list to config file.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //message
        (new \TaliumAttributes\Handler\RouterHandler)
            ->pushToConfig();
        $this->info('Controllers pushed to config file.');
    }
}
