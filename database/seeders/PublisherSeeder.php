<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            ['PublisherName' => 'Penguin Books'],
            ['PublisherName' => 'HarperCollins'],
            ['PublisherName' => 'Bloomsbury'],
            ['PublisherName' => 'Simon & Schuster'],
            ['PublisherName' => 'Random House'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate($publisher);
        }
    }
}
