<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin;
        $admin->name = 'IntSource';
        $admin->username = 'admin';
        $admin->password = Hash::make('123456');
        $admin->save();
    }
}
