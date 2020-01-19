<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
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
        if($this->option('delete'))
        {
            $this->info("Delete selected");
            return;
        }
        $superadmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $moderator = Role::create(['name' => 'Moderator']);
        $basicuser = Role::create(['name' => 'Basic User']);

        $createdog = Permission::create(['name' => 'Create Dog'])->syncRoles([$admin, $moderator, $basicuser]);
        $editdog = Permission::create(['name' => 'Edit Dog'])->syncRoles([$admin, $moderator, $basicuser]);
        $editalldogs = Permission::create(['name' => 'Edit All Dogs'])->syncRoles([$admin, $moderator]);
        $accessbackend = Permission::create(['name' => 'Access Backend'])->syncRoles([$admin, $moderator]);
        $setserveroptions = Permission::create(['name' => 'Set Server Options'])->syncRoles([$admin]);

        $user = User::create([
            'name' => $this->option('user') ?? 'Admin',
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password'))
        ]);

        $user->assignRole($superadmin);

        return;
    }
}
