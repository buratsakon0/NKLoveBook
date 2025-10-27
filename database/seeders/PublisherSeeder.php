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
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate($publisher);
        }
    }
}
