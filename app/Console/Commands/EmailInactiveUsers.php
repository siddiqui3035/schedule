<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NotifyInactiveUser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EmailInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Inactive Users';

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
        $limit = Carbon::now()->subDay(7);

        $inactive_users = User::where('last_login', '<', '2022-02-10 09:00:00')->get();

        foreach($inactive_users as $user)
        {
            $user->notify(new NotifyInactiveUser());
            $this->info('Email send to' .$user->email);
        }
        
        // $this->info($limit);
        // return 0;
    }
}
