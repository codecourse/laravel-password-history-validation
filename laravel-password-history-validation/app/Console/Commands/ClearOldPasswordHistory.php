<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ClearOldPasswordHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password-history:clear {--keep=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old password history';

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
        User::chunk(100, function ($users) {
            $users->each->deletePasswordHistory($this->option('keep'));
        });
    }
}
