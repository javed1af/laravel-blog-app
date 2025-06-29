<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run SuperAdminSeeder first.');
            return;
        }

        $samplePosts = [
            [
                'title' => 'Welcome to Our Blog',
                'content' => 'This is our first blog post. We are excited to share our thoughts and ideas with you.',
                'status' => 'published',
            ],
            [
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a powerful PHP framework that makes web development enjoyable and creative.',
                'status' => 'published',
            ],
            [
                'title' => 'Best Practices for Web Development',
                'content' => 'In this post, we will discuss some of the best practices that every web developer should follow.',
                'status' => 'draft',
            ],
            [
                'title' => 'Understanding Authentication',
                'content' => 'Authentication is a crucial part of any web application. Let\'s explore how to implement it properly.',
                'status' => 'published',
            ],
            [
                'title' => 'Database Design Principles',
                'content' => 'Good database design is the foundation of a robust application. Here are some key principles to follow.',
                'status' => 'draft',
            ],
        ];

        foreach ($samplePosts as $postData) {
            $user = $users->random();
            Post::create([
                'title' => $postData['title'],
                'content' => $postData['content'],
                'status' => $postData['status'],
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('Sample posts created successfully!');
    }
}
