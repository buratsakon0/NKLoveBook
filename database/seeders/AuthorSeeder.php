<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['AuthorName' => 'คาลิ'], // Fiction
            ['AuthorName' => 'Saka Mikami'], // Comics/Manga
            ['AuthorName' => 'ศศิ วีระเศรษฐกุล'], // Art & Design
            ['AuthorName' => 'คาโกะ ฮาเซงาวะ'], // Children's Book

            // Art & Design
            ['AuthorName' => 'Susan Magsamen และ Ivy Ross'],
            ['AuthorName' => 'Kanis'],
            ['AuthorName' => 'ตะวัน วัตุยา'],
            ['AuthorName' => 'กองบรรณาธิการนิตยสาร Room'],
            ['AuthorName' => 'ฮานะ สึกิมิซุ / ซัตสึกิ'],
            ['AuthorName' => 'Wally and Amanda Koval'],
            ['AuthorName' => 'ภาณุ ตรัยเวช'],
            ['AuthorName' => 'มนสิชา รุ่งชวาลนนท์'],
            ['AuthorName' => 'Blake Snyder'],

            // Comics/Manga
            ['AuthorName' => 'Tatsuki Fujimoto'],
            ['AuthorName' => 'KANEHITO YAMA/TSUKASA ABE'],
            ['AuthorName' => 'Yukinobu Tatsu'],
            ['AuthorName' => 'Suu Morishita'],
            ['AuthorName' => 'สุมิโกะ อาราอิ'],
            ['AuthorName' => 'Karuho Shiina'],
            ['AuthorName' => 'Ryoko Kui'],
            ['AuthorName' => 'ยูโตะ ซาโนะ'],
            ['AuthorName' => 'อากิ ฮามาจิ'],

            // Health & Lifestyle
            ['AuthorName' => 'มือเขียน'],
            ['AuthorName' => 'กองบก.นิตยสารบ้านและสวน'],
            ['AuthorName' => 'วิรัชญา จารุจารีต'],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
