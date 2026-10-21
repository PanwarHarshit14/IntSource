<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Seeder;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Register::count() === 0) {
            Register::factory()->count(12)->create();
        }
    }
}
