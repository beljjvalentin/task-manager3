<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json = File::get(public_path("data/tasks_data.json"));
        $data = json_decode($json, true);

        $progressBar = new ProgressBar($this->command->getOutput(), count($data));
        foreach ($data as $category) {
            $categoryId = DB::table('task_categories')->insertGetId([
                'name' => $category['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $myUserId = DB::table('users')->where('email', '=', 'c0886610@mylambton.ca')->id;

            foreach ($category['tasks'] as $task) {
                DB::table('tasks')->insert([
                    'name' => $task['name'],
                    'date' => Carbon::parse($task['date']),
                    'urgency' => $task['urgency'] ?? 1,
                    'category_id' => $categoryId,
                    'user_id' => $myUserId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            $progressBar->advance();
        }
        $progressBar->finish();
        echo "\n";
    }
}
