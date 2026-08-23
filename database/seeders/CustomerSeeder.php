<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => '山田 太郎',
            'email' => 'yamada@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
