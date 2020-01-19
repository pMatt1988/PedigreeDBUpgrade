<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InstallPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permissions {email} {password} {--user=Admin} {--delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application to your server.';

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

        Artisan::call('uninstall:permissions');

        if ($this->option('delete')) {
            $this->info("Delete selected");
            return;
        }
        $superadmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $moderator = Role::create(['name' => 'Moderator']);
        $basicuser = Role::create(['name' => 'Basic User']);

        Permission::create(['name' => 'Create Dog'])->syncRoles([$admin, $moderator, $basicuser]);
        Permission::create(['name' => 'Edit Dog'])->syncRoles([$admin, $moderator, $basicuser]);
        Permission::create(['name' => 'Edit All Dogs'])->syncRoles([$admin, $moderator]);
        Permission::create(['name' => 'Access Backend'])->syncRoles([$admin, $moderator]);
        Permission::create(['name' => 'Set Server Options'])->syncRoles([$admin]);
        Permission::create(['name' => 'Edit Users'])->syncRoles([$admin]);
        $this->info('Succesfully Installed Permissions!');
        $user = User::where(['email' => $this->argument('email')])->first();
        if ($user === null) {
            $user = User::create([
                'name' => $this->option('user') ?? 'Admin',
                'email' => $this->argument('email'),
                'password' => Hash::make($this->argument('password'))
            ]);

            $this->info('Succesfully Created Admin User with Email: ' . $user->email);

        }

        if(!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
            $this->info('Assigned Super Admin Role to User with Email: ' .  $user->email);
        }
        return;
    }
}
