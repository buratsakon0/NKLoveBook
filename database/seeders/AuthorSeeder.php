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
            ['AuthorName' => 'กองบรรณาธิการแสงแดด'],
            ['AuthorName' => 'นิตยสาร Health Cuisine กอง บก.'],
            ['AuthorName' => 'poiluang_healthy'],
            ['AuthorName' => 'ศุภวุฒิ สายเชื้อ ดร.'],
            ['AuthorName' => 'ชิดชนก ทองใหญ่ ณ อยุธยา'],
            ['AuthorName' => 'นายแพทย์ธนีย์ ธนียวัน'],
            ['AuthorName' => 'ทิพาพรรณ ศิริเวชฎารักษ์,ปัญชัช ชั่งจันทร'],

            // Travel
            ['AuthorName' => 'dsin'],
            ['AuthorName' => 'กองบรรณาธิการ แจ่มใส'],
            ['AuthorName' => 'เอกชัย สุขวัฒนกูล'],
            ['AuthorName' => 'B TRAVEL TEAM'],
            ['AuthorName' => 'การท่องเที่ยวแห่งประเทศไทย'],
            ['AuthorName' => 'Travelkanuman'],
            ['AuthorName' => 'TWIN x TRAVEL'],
            ['AuthorName' => 'นัฏนนเสนาแสง'],

            // Fiction
            ['AuthorName' => 'เจ้าปลาน้อย'],
            ['AuthorName' => 'Bikabi (ปี่ข่าปี่)'],

            // Children’s book
            ['AuthorName' => 'กองบรรณาธิการ'],
            ['AuthorName' => 'ชิวเจียฮุ่ย'],
            ['AuthorName' => 'Devin Elle Kurtz'],

            // Education & Learning
            ['AuthorName' => 'นามิ โนจิมะ'],
            ['AuthorName' => 'กองบรรณาธิการ Think Beyond Education'],
            ['AuthorName' => 'Dr.Barbara Oakley'],
            ['AuthorName' => 'Melissa S.'],

            // Science & Technology
            ['AuthorName' => 'Jack Lewis'],
            ['AuthorName' => 'What on Earth'],
            ['AuthorName' => 'ศุภวิทย์ ถาวรบุตร'],
            ['AuthorName' => 'บัญชา ปะสีละเตสัง'],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate($author);
        }
    }
}
