<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['AuthorName' => 'คาลิ'], //1 Fiction
            ['AuthorName' => 'Saka Mikami'], //2 Comics/Manga
            ['AuthorName' => 'ศศิ วีระเศรษฐกุล'], //3 Art & Design
            ['AuthorName' => 'คาโกะ ฮาเซงาวะ'], //4 Children's Book

            // Art & Design
            ['AuthorName' => 'Susan Magsamen และ Ivy Ross'], //5
            ['AuthorName' => 'Kanis'], //6
            ['AuthorName' => 'ตะวัน วัตุยา'], //7
            ['AuthorName' => 'กองบรรณาธิการนิตยสาร Room'], //8
            ['AuthorName' => 'ฮานะ สึกิมิซุ / ซัตสึกิ'], //10
            ['AuthorName' => 'Wally and Amanda Koval'], //11
            ['AuthorName' => 'ภาณุ ตรัยเวช'], //12
            ['AuthorName' => 'มนสิชา รุ่งชวาลนนท์'], //13
            ['AuthorName' => 'Blake Snyder'], //14

            // Comics/Manga
            ['AuthorName' => 'Tatsuki Fujimoto'], //9
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
