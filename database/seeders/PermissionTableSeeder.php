<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'create-role',
                'display_name' => 'Create Role ',
                'group' => 'Role Management'
            ],
            [
                'name' => 'read-role',
                'display_name' => 'Read Role ',
                'group' => 'Role Management'
            ],
            [
                'name' => 'update-role',
                'display_name' => 'Update Role ',
                'group' => 'Role Management'
            ],
            [
                'name' => 'create-user',
                'display_name' => 'Create User ',
                'group' => 'User Management'
            ],
            [
                'name' => 'read-user',
                'display_name' => 'Read User ',
                'group' => 'User Management'
            ],
            [
                'name' => 'update-user',
                'display_name' => 'Update User ',
                'group' => 'User Management'
            ],

            [
                'name' => 'professional-user',
                'display_name' => 'Professional User ',
                'group' => 'User Base Permission'
            ],
            [
                'name' => 'general-user',
                'display_name' => 'General User ',
                'group' => 'User Base Permission'
            ],


            [
                'name' => 'create-livestream',
                'display_name' => 'Create Live Stream',
                'group' => 'Livestream Management'
            ],
            [
                'name' => 'read-livestream',
                'display_name' => 'Read Live Stream',
                'group' => 'Livestream Management'
            ],
            [
                'name' => 'update-livestream',
                'display_name' => 'Update Live Stream',
                'group' => 'Livestream Management'
            ],
            [
                'name' => 'purchase-livestream',
                'display_name' => 'Purchase Live Stream',
                'group' => 'Livestream Management'
            ],

            [
                'name' => 'read-booked-livestream',
                'display_name' => 'Read Booked Livestream',
                'group' => 'Livestream Booked Management'
            ],
            [
                'name' => 'create-evaluation-livestream',
                'display_name' => 'Create Evaluation Livestream',
                'group' => 'Livestream Evaluation Management'
            ],
            [
                'name' => 'read-evaluation-livestream',
                'display_name' => 'Read Evaluation Livestream',
                'group' => 'Livestream Evaluation Management'
            ],
            [
                'name' => 'read-assessment-livestream',
                'display_name' => 'Read Assessment Livestream',
                'group' => 'Livestream Assessment Management'
            ],
            [
                'name' => 'read-certificate-livestream',
                'display_name' => 'Read Certificate Livestream',
                'group' => 'Livestream Certificate Management'
            ],



            [
                'name' => 'create-webinar',
                'display_name' => 'Create Webinar',
                'group' => 'Webinar Management'
            ],
            [
                'name' => 'read-webinar',
                'display_name' => 'Read Webinar',
                'group' => 'Webinar Management'
            ],
            [
                'name' => 'update-webinar',
                'display_name' => 'Update Webinar',
                'group' => 'Webinar Management'
            ],
            [
                'name' => 'purchase-webinar',
                'display_name' => 'Purchase Webinar',
                'group' => 'Webinar Management'
            ],

            [
                'name' => 'read-booked-webinar',
                'display_name' => 'Read Booked Webinar',
                'group' => 'Webinar Booked Management'
            ],
            [
                'name' => 'create-evaluation-webinar',
                'display_name' => 'Create Evaluation Webinar',
                'group' => 'Webinar Evaluation Management'
            ],
            [
                'name' => 'read-evaluation-webinar',
                'display_name' => 'Read Evaluation Webinar',
                'group' => 'Webinar Evaluation Management'
            ],
            [
                'name' => 'read-assessment-webinar',
                'display_name' => 'Read Assessment Webinar',
                'group' => 'Webinar Assessment Management'
            ],
            [
                'name' => 'read-certificate-webinar',
                'display_name' => 'Read Certificate Webinar',
                'group' => 'Webinar Certificate Management'
            ],

        ];
        foreach($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
