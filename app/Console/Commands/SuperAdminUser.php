<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SuperAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grants a user Super Admin powers on your sever.';

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
        //
        $user = User::where('email', $this->argument('email'))->first();

        if($user !== null) {
            if(!$user->hasRole('Super Admin')) {
                $user->assignRole('Super Admin');
                $this->info('Assigned Super Admin Role to ' . $user->email);
            }
            else {
                $this->error($user->email . ' is already a Super Admin');
            }
        }
        else {
            $this->error('User does not exist. Register your user before using this command!');
        }

    }
}
