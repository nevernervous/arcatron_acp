<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use DB;
use Hash;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Admin User.';

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
        try {
            DB::beginTransaction();

            $this->comment('------------------');
            $this->comment('Create an admin user.');

            $name  = $this->ask('Enter user name:');
            $email = $this->ask('Enter email address:');
            $password = $this->secret('Enter a password:');

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->live_access = true;
            $user->search_access = true;
            $user->logs_access = true;
            $user->save();

            $adminRole = Role::where('name', 'admin')->first();
            $user->attachRole($adminRole);

            DB::commit();

            $this->info('Admin user successfully created.');
        }catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error Creating User.');
            $this->error($e);
        }
    }
}
