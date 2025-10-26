<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['AuthorName' => 'คาลิ'],
            ['AuthorName' => 'Saka Mikami'],
            ['AuthorName' => 'ศศิ วีระเศรษฐกุล'],
            ['AuthorName' => 'คาโกะ ฮาเซงาวะ'],
            ['AuthorName' => 'คาโกะ ฮาเซงาวะ'],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
