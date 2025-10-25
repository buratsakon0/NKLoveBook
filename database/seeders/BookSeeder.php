<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fiction = Category::where('CategoryName', 'Fiction')->first();
        $science = Category::where('CategoryName', 'Science & Technology')->first();
        $manga = Category::where('CategoryName', 'Comics / Manga')->first();

        $murakami = Author::where('AuthorName', 'Haruki Murakami')->first();
        $jk = Author::where('AuthorName', 'J.K. Rowling')->first();
        $dan = Author::where('AuthorName', 'Dan Brown')->first();

        $penguin = Publisher::where('PublisherName', 'Penguin Books')->first();
        $harper = Publisher::where('PublisherName', 'HarperCollins')->first();
        $bloomsbury = Publisher::where('PublisherName', 'Bloomsbury')->first();

        $books = [
            [
                'BookName' => 'Kafka on the Shore',
                'ISBN' => '978-0099458326',
                'Price' => 299.00,
                'Pages' => 480,
                'Description' => 'A surreal masterpiece by Haruki Murakami.',
                'CategoryID' => $fiction->CategoryID ?? 1,
                'PublisherID' => $penguin->PublisherID ?? 1,
                'AuthorID' => $murakami->AuthorID ?? 1,
            ],
            [
                'BookName' => 'Harry Potter and the Sorcerer\'s Stone',
                'ISBN' => '978-0747532699',
                'Price' => 350.00,
                'Pages' => 320,
                'Description' => 'The first magical adventure of Harry Potter.',
                'CategoryID' => $fiction->CategoryID ?? 1,
                'PublisherID' => $bloomsbury->PublisherID ?? 3,
                'AuthorID' => $jk->AuthorID ?? 2,
            ],
            [
                'BookName' => 'The Da Vinci Code',
                'ISBN' => '978-0307474278',
                'Price' => 420.00,
                'Pages' => 590,
                'Description' => 'A thrilling mystery full of art, religion, and history.',
                'CategoryID' => $fiction->CategoryID ?? 1,
                'PublisherID' => $harper->PublisherID ?? 2,
                'AuthorID' => $dan->AuthorID ?? 3,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(['ISBN' => $book['ISBN']], $book);
        }
    }
}
