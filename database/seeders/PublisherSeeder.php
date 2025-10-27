<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            ['PublisherName' => 'คาลิ'], // Fiction
            ['PublisherName' => 'PHOENIX'], // Comics/Manga
            ['PublisherName' => 'FULLSTOP'], // Art & Design
            ['PublisherName' => 'Amarin Kids'], // Children's Book

            // Art & Design
            ['PublisherName' => 'Bookscape'],
            ['PublisherName' => '10 มิลลิเมตร'],
            ['PublisherName' => 'เอ็มไอเอส,สนพ./MISBook'],
            ['PublisherName' => 'บ้านและสวน'],
            ['PublisherName' => 'Sunday Afternoon'],
            ['PublisherName' => 'BROCCOLI'],
            ['PublisherName' => 'gypzy'],
            ['PublisherName' => 'Salmon Books'],

            // Comics/Manga
            ['PublisherName' => 'Siam Inter Comics'],
            ['PublisherName' => 'Bongkoch Publishing'],
            ['PublisherName' => 'Dexpress Publishing'],

            // Health & Lifestyle
            ['PublisherName' => 'สวนเงินมีมา/Suan Ngoen Mi Ma'],
            ['PublisherName' => 'แสงแดด/sangdad'],
            ['PublisherName' => 'อมรินทร์สุขภาพ'],
            ['PublisherName' => 'STEPS'],
            ['PublisherName' => 'openbooks, สนพ.'],
            ['PublisherName' => 'อมรินทร์ How to'],
            ['PublisherName' => 'ไลฟ์พลัส Life+'],

            // Travel
            ['PublisherName' => 'dsin'],
            ['PublisherName' => 'แจ่มใส'],
            ['PublisherName' => 'วิช กรุ๊ป (ไทยแลนด์)'],
            ['PublisherName' => 'Book Caff'],
            ['PublisherName' => 'การท่องเที่ยวแห่งประเทศไทย'],
            ['PublisherName' => 'Dplus Guide'],
            ['PublisherName' => 'อมรินทร์ท่องโลก'],
            ['PublisherName' => 'ธิงค์ บียอนด์ บุ๊คส์, บจก.'],

            // Fiction
            ['PublisherName' => 'รัตนนาม'],
            ['PublisherName' => 'เพชรไพลิน รัตนนาม'],
            ['PublisherName' => 'เอเวอร์วาย'],

            // Children’s book
            ['PublisherName' => 'I.S.Practical'],
            ['PublisherName' => 'YF CULTURE'],
            ['PublisherName' => 'Little Heart'],

            // Education & Learning
            ['PublisherName' => 'ธิงค์บียอนด์/Think Beyond'],
            ['PublisherName' => 'บิงโก/bingobook'],
            ['PublisherName' => 'ดี.เค.บุ๊ค ดิสทริบิว'],

            // Science & Technology
            ['PublisherName' => 'กาลาปากอส'],
            ['PublisherName' => 'Bounce'],
            ['PublisherName' => 'ยิปซี/Gypzy'],
            ['PublisherName' => 'ซีเอ็ดยูเคชั่น/se-ed'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate($publisher);
        }
    }
}
