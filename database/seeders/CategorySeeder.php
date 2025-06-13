<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology'],
            ['name' => 'Business'],
            ['name' => 'Education'],
            ['name' => 'Health & Wellness'],
            ['name' => 'Arts & Culture'],
            ['name' => 'Sports & Recreation'],
            ['name' => 'Food & Drink'],
            ['name' => 'Music & Entertainment'],
            ['name' => 'Networking'],
            ['name' => 'Professional Development'],
            ['name' => 'Community'],
            ['name' => 'Science & Research'],
            ['name' => 'Travel & Tourism'],
            ['name' => 'Fashion & Beauty'],
            ['name' => 'Finance & Investment'],
            ['name' => 'Marketing & Sales'],
            ['name' => 'Non-Profit & Charity'],
            ['name' => 'Government & Politics'],
            ['name' => 'Family & Parenting'],
            ['name' => 'Hobbies & Crafts']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
