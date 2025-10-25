<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['AuthorName' => 'Haruki Murakami'],
            ['AuthorName' => 'J.K. Rowling'],
            ['AuthorName' => 'Dan Brown'],
            ['AuthorName' => 'Yuval Noah Harari'],
            ['AuthorName' => 'Agatha Christie'],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
