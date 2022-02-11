<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Inactive User';

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
     * @return int
     */
    public function handle()
    {
        $inactive_users = User::where('last_login', null)->get();

        foreach($inactive_users as $user)
        {
            $user->delete();
        }

        // return 0;
    }
}
