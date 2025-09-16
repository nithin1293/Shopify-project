<?php

namespace Database\Seeders;

use App\Models\Address;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Address::create([
           
    'user_id'       => 1,
    'address_line_1'=> '123 Main St',
    'address_line_2'=> 'Apt 4B',
    'city'          => 'Hyderabad',
    'state'         => 'Telangana',
    'postal_code'   => '500001',
    'country'       => 'India',


        ]);
    }
}
