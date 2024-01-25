<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'hashir.iqbal@gmail.com',
                'password' => bcrypt('delldell'),
                'role_id' => 0,
                'branch_id' => 1,
            ]
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
