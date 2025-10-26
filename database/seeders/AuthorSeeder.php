<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['AuthorName' => 'คาลิ'], //1
            ['AuthorName' => 'Saka Mikami'], //2
            ['AuthorName' => 'ศศิ วีระเศรษฐกุล'], //3
            ['AuthorName' => 'คาโกะ ฮาเซงาวะ'], //4

            // Art & Design
            ['AuthorName' => 'Susan Magsamen และ Ivy Ross'], //5
            ['AuthorName' => 'Kanis'], //6
            ['AuthorName' => 'ตะวัน วัตุยา'], //7
            ['AuthorName' => 'กองบรรณาธิการนิตยสาร Room'], //8
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
