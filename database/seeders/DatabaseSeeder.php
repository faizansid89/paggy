<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       //  $this->call( AreasTableSeeder::class);
       //  $this->call( CityTableSeeder::class);
       $this->call( \UserTableDataSeeder::class);
       $this->call( \PermissionTableSeeder::class);
//       $this->call( [ProductUnitTableSeeder::class,]);
      $this->call( RolesTableSeeder::class);
//       $this->call( CustomerTableSeeder::class);
    }
}
