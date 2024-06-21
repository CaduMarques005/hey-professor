<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Cadu Marques',
            'email' => 'cadugoleiro12@gmail.com',
            'password' => bcrypt('Cadu@2505'),
        ]);

        Question::factory()->count(10)->create();

    }
}
