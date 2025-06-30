<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 5; $i++) {
            $notification = Notification::create([
                'title' => 'Demo Notification Title #' . $i,
                'message' => 'This is a demo notification message content for notification number ' . $i,
                'created_by' => $users->random()->id,
            ]);
            $notification->users()->attach($users->random(min(3, $users->count()))->pluck('id')->toArray());
        }
    }
}
