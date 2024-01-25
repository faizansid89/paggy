<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'status' => '1'
            ],
            [
                'name' => 'Professional Educator',
                'status' => '1'
            ],
            [
                'name' => 'General Public',
                'status' => '1'
            ],
        ];

        foreach($roles as $role) {
            Role::create($role);
        }
    }
}
