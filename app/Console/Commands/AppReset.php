<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->call('passport:install',['--force' => true]);
        $this->call('telescope:install');
    }
}
