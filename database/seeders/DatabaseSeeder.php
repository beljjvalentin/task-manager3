<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Valentin Belii',
            'email' => 'c0886610@mylambton.ca',
        ]);

        User::factory(10)->create();

        // Call the TasksSeeder
        $this->call(TaskSeeder::class);
    }
}
