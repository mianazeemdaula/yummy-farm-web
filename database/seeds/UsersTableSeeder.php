<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super-admin',
            'status' => 'active',
        ]);

        $admin = User::create([
            'name' => 'Admin One',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $user = User::create([
            'name' => 'Seller One',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'location' => new Point(50.815990,3.821200),
            'seller_number' => '001',
            'plan_id' => 1,
            'fcm_token' => 'fcm_token',
            'firstname' => 'firstname',
            'username' => 'username',
            'business_name' => 'business_name',
            'address' => 'address_one',
            'country' => 'UK',
            'phone' => 'phone',
            'vat' => 'vat',
            'bank_account' => '0156565895',
            'rpr' => 'rpr',
            'status' => 'inactive'
        ]);

        $user = User::create([
            'name' => 'Seller Two',
            'email' => 'mazeemrehan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            // 'location' => new Point(30.672456, 73.666468),
            'location' => new Point(50.815532, 3.821715),
            'seller_number' => '002',
            'plan_id' => 1,
            'fcm_token' => 'fcm_token',
            'firstname' => 'Azeem',
            'username' => 'mazeemrehan',
            'business_name' => 'Code With',
            'address' => 'Rasheed u din colony',
            'country' => 'UK',
            'phone' => '+302656565655',
            'vat' => 'AB6565655',
            'bank_account' => '0156565895',
            'rpr' => 'rpr',
            'status' => 'inactive'
        ]);

        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        
    }
}
