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
            'firstname' => 'Seller',
            'username' => 'sellerone',
            'business_name' => 'Fresh Fruits',
            'address' => '1095 Gocery ET',
            'address_line_2' => 'Philli',
            'country' => 'UK',
            'phone' => '6895659598',
            'vat' => 'BX1235.655.658.256',
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
            'username' => 'Noder Ms',
            'business_name' => 'Code With',
            'address' => 'Rasheed u din colony',
            'country' => 'UK',
            'phone' => '+302656565655',
            'vat' => 'BX6565.655.658.256',
            'bank_account' => 'BE01.565.658.955',
            'rpr' => 'RX656565',
            'status' => 'inactive'
        ]);

        $user = User::create([
            'name' => 'John',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'firstname' => 'ABx Cm',
            'username' => 'customer',
            'phone' => '+25656565655',
            'vat' => 'BX6565.655.658.256',
            'bank_account' => 'BE01.565.658.955',
            'address' => '256 Fiat Nor',
            'address_line_2' => 'Jakcob, St # 56',
            'country' => 'UK',
        ]);
        
    }
}
