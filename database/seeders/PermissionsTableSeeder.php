<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 1,
                'name' => 'Add User',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 2,
                'name' => 'Edit User',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 3,
                'name' => 'Delete User',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 4,
                'name' => 'Add Role',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 5,
                'name' => 'Edit Role',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 6,
                'name' => 'Delete Role',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 7,
                'name' => 'Add Permission',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 8,
                'name' => 'Edit Permission',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 9,
                'name' => 'Delete Permission',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 10,
                'name' => 'Edit Setting',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 11,
                'name' => 'List Audit Logs',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 12,
                'name' => 'List Role',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 13,
                'name' => 'List Permission',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 14,
                'name' => 'List User',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 15,
                'name' => 'List Menu',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 16,
                'name' => 'Access Admin',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'created_at' => NULL,
                'guard_name' => 'web',
                'id' => 17,
                'name' => 'Manage CMS',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}