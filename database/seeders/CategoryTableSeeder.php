<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'All about the latest in technology.',
                'status' => 1,
            ],
            [
                'name' => 'Travel',
                'description' => 'Explore the world with our travel tips.',
                'status' => 1,
            ],
            [
                'name' => 'Food',
                'description' => 'Discover delicious recipes and food trends.',
                'status' => 1,
            ],
            [
                'name' => 'Fashion',
                'description' => 'Stay stylish with the latest fashion news and trends.',
                'status' => 1,
            ],
            [
                'name' => 'Sports',
                'description' => 'Get updates on your favorite sports teams and athletes.',
                'status' => 1,
            ],
            [
                'name' => 'Health',
                'description' => 'Stay healthy with our fitness and wellness tips.',
                'status' => 1,
            ],
            [
                'name' => 'Music',
                'description' => 'Discover new music and read about your favorite artists.',
                'status' => 1,
            ],
            [
                'name' => 'Movies',
                'description' => 'Stay up-to-date with the latest movie releases and reviews.',
                'status' => 1,
            ],
            [
                'name' => 'Books',
                'description' => 'Explore new books and get reading recommendations.',
                'status' => 1,
            ],
            [
                'name' => 'Art',
                'description' => 'Discover amazing art and artists from around the world.',
                'status' => 1,
            ],
            [
                'name' => 'Science',
                'description' => 'Explore the wonders of science and technology.',
                'status' => 1,
            ],
            [
                'name' => 'History',
                'description' => 'Learn about historical events and figures.',
                'status' => 1,
            ],
            [
                'name' => 'Business',
                'description' => 'Stay informed about business news and trends.',
                'status' => 1,
            ],
            [
                'name' => 'Education',
                'description' => 'Get tips and resources for learning and education.',
                'status' => 1,
            ],
            [
                'name' => 'Gaming',
                'description' => 'Explore the world of gaming and video games.',
                'status' => 1,
            ],
            [
                'name' => 'Fitness',
                'description' => 'Stay fit and healthy with our fitness tips and workouts.',
                'status' => 1,
            ],
            [
                'name' => 'Photography',
                'description' => 'Learn about photography techniques and equipment.',
                'status' => 1,
            ],
            [
                'name' => 'Home Decor',
                'description' => 'Get ideas and inspiration for decorating your home.',
                'status' => 1,
            ],
            [
                'name' => 'Pets',
                'description' => 'Learn about pet care and discover new pet products.',
                'status' => 1,
            ],
            [
                'name' => 'Nature',
                'description' => 'Explore the beauty of nature and conservation efforts.',
                'status' => 1,
            ],
        ];

        // Remove duplicates based on the category name
        $categories = array_unique($categories, SORT_REGULAR);

        DB::table('categories')->insert($categories);
    }
}
