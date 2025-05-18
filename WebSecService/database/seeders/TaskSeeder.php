<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Task::insert([
            [
                'title' => 'Finish report',
                'description' => 'Complete the annual report.',
                'status' => 'pending',
                'due_date' => now()->addDays(7),
                'user_id' => $user ? $user->id : 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Team meeting',
                'description' => 'Discuss project milestones.',
                'status' => 'completed',
                'due_date' => now()->addDays(2),
                'user_id' => $user ? $user->id : 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
