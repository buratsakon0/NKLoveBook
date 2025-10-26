<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            ['PublisherName' => 'คาลิ'],
            ['PublisherName' => 'PHOENIX'],
            ['PublisherName' => 'FULLSTOP'],
            ['PublisherName' => 'Amarin Kids'],
            ['PublisherName' => 'Amarin Kids'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate($publisher);
        }
    }
}
