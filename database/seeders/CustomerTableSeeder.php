<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer  = new Customer();
        $customer->id =  0;
        $customer->name =  'Walk-In Customer';
        $customer->phone =  '123456789';
        $customer->status =  1;
        $customer->save();
    }
}
