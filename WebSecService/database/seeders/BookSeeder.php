<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'published_year' => 2008,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt',
                'published_year' => 1999,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
