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
            'name' => 'Seller',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'location' => new Point(30.671456, 73.656468),
            'seller_number' => 'A5650VV',
            'plan_id' => 1,
            'fcm_token' => 'fcm_token',
            'firstname' => 'firstname',
            'username' => 'username',
            'business_name' => 'business_name',
            'address_one' => 'address_one',
            'address_two' => 'address_two',
            'phone' => 'phone',
            'vat' => 'vat',
            'bank_account' => 'bank_account',
            'rpr' => 'rpr',
        ]);

        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        
    }
}
