<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            ['PublisherName' => 'คาลิ'], //1 Fiction
            ['PublisherName' => 'PHOENIX'], //2 Comics/Manga
            ['PublisherName' => 'FULLSTOP'], //3 Art & Design
            ['PublisherName' => 'Amarin Kids'], //4 Children's Book

            // Art & Design
            ['PublisherName' => 'Bookscape'], //5
            ['PublisherName' => '10 มิลลิเมตร'], //6
            ['PublisherName' => 'เอ็มไอเอส,สนพ./MISBook'], //7
            ['PublisherName' => 'บ้านและสวน'], //8
            ['PublisherName' => 'Sunday Afternoon'], //10
            ['PublisherName' => 'BROCCOLI'], //11
            ['PublisherName' => 'gypzy'], //12
            ['PublisherName' => 'Salmon Books'], //13
           // ['PublisherName' => 'Bookscape'], //14

            // Comics/Manga
            ['PublisherName' => 'Siam Inter Comics'], //9
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate($publisher);
        }
    }
}
