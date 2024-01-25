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
//            [
//                'name' => 'create-category',
//                'display_name' => 'Create Category',
//                'group' => 'Category Management'
//            ],
//            [
//                'name' => 'read-category',
//                'display_name' => 'Read Category',
//                'group' => 'Category Management'
//            ],
//            [
//                'name' => 'update-category',
//                'display_name' => 'Update Category',
//                'group' => 'Category Management'
//            ],
//
//            [
//                'name' => 'create-subcategory',
//                'display_name' => 'Create Subcategory',
//                'group' => 'Subcategory Management'
//            ],
//            [
//                'name' => 'read-subcategory',
//                'display_name' => 'Read Subcategory',
//                'group' => 'Subcategory Management'
//            ],
//            [
//                'name' => 'update-subcategory',
//                'display_name' => 'Update Subcategory',
//                'group' => 'Subcategory Management'
//            ],
//            [
//                'name' => 'create-product',
//                'display_name' => 'Create Product',
//                'group' => 'Product Management'
//            ],
//            [
//                'name' => 'read-product',
//                'display_name' => 'Read Product',
//                'group' => 'Product Management'
//            ],
//            [
//                'name' => 'update-product',
//                'display_name' => 'Update Product',
//                'group' => 'Product Management'
//            ],
//            [
//                'name' => 'create-brand',
//                'display_name' => 'Create Brand',
//                'group' => 'Brand Management'
//            ],
//            [
//                'name' => 'read-brand',
//                'display_name' => 'Read Brand',
//                'group' => 'Brand Management'
//            ],
//            [
//                'name' => 'update-brand',
//                'display_name' => 'Update Brand',
//                'group' => 'Brand Management'
//            ],
//
//            [
//                'name' => 'create-customer',
//                'display_name' => 'Create Customer ',
//                'group' => 'Customer Management'
//            ],
//            [
//                'name' => 'read-customer',
//                'display_name' => 'Read Customer ',
//                'group' => 'Customer Management'
//            ],
//            [
//                'name' => 'update-customer',
//                'display_name' => 'Update Customer ',
//                'group' => 'Customer Management'
//            ],
//
//             [
//                'name' => 'create-supplier',
//                'display_name' => 'Create Supplier ',
//                'group' => 'Supplier Management'
//            ],
//            [
//                'name' => 'read-supplier',
//                'display_name' => 'Read Supplier ',
//                'group' => 'Supplier Management'
//            ],
//            [
//                'name' => 'update-supplier',
//                'display_name' => 'Update Supplier ',
//                'group' => 'Supplier Management'
//            ],
//            [
//                'name' => 'create-branch',
//                'display_name' => 'Create Branch ',
//                'group' => 'Branch Management'
//            ],
//            [
//                'name' => 'read-branch',
//                'display_name' => 'Read Branch ',
//                'group' => 'Branch Management'
//            ],
//            [
//                'name' => 'update-branch',
//                'display_name' => 'Update Branch ',
//                'group' => 'Branch Management'
//            ],
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
//            [
//                'name' => 'create-purchase',
//                'display_name' => 'Create Purchase ',
//                'group' => 'Purchase Management'
//            ],
//            [
//                'name' => 'read-purchase',
//                'display_name' => 'Read Purchase ',
//                'group' => 'Purchase Management'
//            ],
//            [
//                'name' => 'update-advertisement',
//                'display_name' => 'Update Advertisement ',
//                'group' => 'Advertisement Management'
//            ],
//            [
//                'name' => 'create-advertisement',
//                'display_name' => 'Create Advertisement ',
//                'group' => 'Advertisement Management'
//            ],
//            [
//                'name' => 'read-advertisement',
//                'display_name' => 'Read Advertisement ',
//                'group' => 'Advertisement Management'
//            ],
//            [
//                'name' => 'update-purchase',
//                'display_name' => 'Update Purchase ',
//                'group' => 'Purchase Management'
//            ],
//            [
//                'name' => 'create-productunit',
//                'display_name' => 'Create Product Unit',
//                'group' => 'Product Unit Management'
//            ],
//            [
//                'name' => 'read-productunit',
//                'display_name' => 'Read Product Unit',
//                'group' => 'Product Unit Management'
//            ],
//            [
//                'name' => 'update-productunit',
//                'display_name' => 'Update Product Unit',
//                'group' => 'Product Unit Management'
//            ],
//            [
//                'name' => 'read-reports',
//                'display_name' => 'Read Reports',
//                'group' => 'Reports Management'
//            ],
//            [
//                'name' => 'create-sales',
//                'display_name' => 'Create Sales',
//                'group' => 'Sales Management'
//            ],
//            [
//                'name' => 'read-sales',
//                'display_name' => 'Read Sales',
//                'group' => 'Sales Management'
//            ],
//            [
//                'name' => 'update-sales',
//                'display_name' => 'Update Sales',
//                'group' => 'Sales Management'
//            ],
//            [
//                'name' => 'read-sync-system',
//                'display_name' => 'Sync System',
//                'group' => 'Branch Wise Access'
//            ],
//            [
//                'name' => 'label-printing',
//                'display_name' => 'Label Printing',
//                'group' => 'Branch Wise Access'
//            ],
//            [
//                'name' => 'pos',
//                'display_name' => 'POS',
//                'group' => 'Branch Wise Access'
//            ],
//            [
//                'name' => 'miss_sale',
//                'display_name' => 'Miss Sale',
//                'group' => 'Miss Sale Access'
//            ],
//            [
//                'name' => 'sync_logs',
//                'display_name' => 'Sync Logs',
//                'group' => 'Sync Logs Access'
//            ],
//            [
//                'name' => 'cities',
//                'display_name' => 'Cities',
//                'group' => 'Cities Access'
//            ],
//            [
//                'name' => 'areas',
//                'display_name' => 'Areas',
//                'group' => 'Areas Access'
//            ],
            [
                'name' => 'read-sync-system',
                'display_name' => 'Sync System',
                'group' => 'Sync System'
            ],

        ];
        foreach($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
