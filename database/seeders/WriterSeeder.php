<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'writer',
            'email' => 'writer2@gmail.com',
            'password' => bcrypt('test1234'),
        ]);

        $user = User::where('email', 'writer2@gmail.com')->first();

        $user->assignRole('writer');
    }
}
