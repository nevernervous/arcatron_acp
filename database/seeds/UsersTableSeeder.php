<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create()->each(function ($u) {
            $operatorRole = App\Models\Role::where('name', 'operator')->first();
            $u->attachRole($operatorRole);
        });
    }
}
