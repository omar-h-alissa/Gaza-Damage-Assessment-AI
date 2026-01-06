<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(2)->pluck('id');

        Activity::insert([
            [
                'user_id' => $users[0],
                'title' => 'Report #105 submitted',
                'type'  => 'primary',
                'icon'  => 'bi-send-fill',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'user_id' => $users[0],
                'title' => 'AI analysis updated for Report #103',
                'type'  => 'danger',
                'icon'  => 'bi-cpu-fill',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'user_id' => $users[0],
                'title' => 'Report #101 marked as completed',
                'type'  => 'success',
                'icon'  => 'bi-check2-circle',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => $users[0],
                'title' => 'Report #99 moved to review stage',
                'type'  => 'warning',
                'icon'  => 'bi-hourglass-split',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'user_id' => $users[0],
                'title' => 'Admin assigned to Report #94',
                'type'  => 'info',
                'icon'  => 'bi-person-check-fill',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
        ]);
    }
}
