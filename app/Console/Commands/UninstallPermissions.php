<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UninstallPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uninstall:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstalls Permissions!';

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
     * @throws \Exception
     */
    public function handle()
    {

        Role::where('name', 'Super Admin')->delete();
        Role::where('name', 'Admin')->delete();
        Role::where('name', 'Moderator')->delete();
        Role::where('name','Basic User')->delete();

        Permission::where('name', 'Create Dog')->delete();
        Permission::where('name', 'Edit Dog')->delete();
        Permission::where('name', 'Edit All Dogs')->delete();
        Permission::where('name', 'Access Backend')->delete();
        Permission::where('name', 'Set Server Options')->delete();
        Permission::where('name', 'Edit Users')->delete();

        $this->info("Successfully Uninstalled Permissions");

        return;

    }
}
