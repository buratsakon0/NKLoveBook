<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['CategoryName' => 'Education & Learning'],
            ['CategoryName' => 'Science & Technology'],
            ['CategoryName' => 'Art & Design'],
            ['CategoryName' => 'Comics / Manga'],
            ['CategoryName' => 'Fiction'],
            ['CategoryName' => "Children's Book"],
            ['CategoryName' => 'Health & Lifestyle'],
            ['CategoryName' => 'Travel'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
