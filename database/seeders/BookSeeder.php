<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'BookName' => 'หนังสือเล่มที่ 1',
                'ISBN' => '9780000000001',
                'Price' => 250.00,
                'Pages' => 180,
                'Description' => 'หนังสือที่ให้แรงบันดาลใจและความรู้',
                'cover_image' => 'bookA.jpg', // ✅ เพิ่มชื่อไฟล์ภาพตรงนี้
                'CategoryID' => 1,
                'PublisherID' => 1,
                'AuthorID' => 1,
            ],
            [
                'BookName' => 'หนังสือเล่มที่ 2',
                'ISBN' => '9780000000002',
                'Price' => 190.00,
                'Pages' => 220,
                'Description' => 'หนังสือแนวศิลปะและการออกแบบ',
                'cover_image' => 'bookB.jpg',
                'CategoryID' => 2,
                'PublisherID' => 1,
                'AuthorID' => 2,
            ],
            [
                'BookName' => 'หนังสือเล่มที่ 3',
                'ISBN' => '9780000000003',
                'Price' => 300.00,
                'Pages' => 240,
                'Description' => 'หนังสือการ์ตูนสนุกอ่านเพลิน',
                'cover_image' => 'bookC.jpg',
                'CategoryID' => 3,
                'PublisherID' => 2,
                'AuthorID' => 3,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(['ISBN' => $book['ISBN']], $book);
        }
    }
}
