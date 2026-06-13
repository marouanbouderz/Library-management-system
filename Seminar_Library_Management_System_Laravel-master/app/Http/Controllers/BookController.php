<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Dummy data so you can see the new UI immediately
        $books = collect([
            (object)[
                'id' => 1,
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '978-3-16-148410-0',
                'status' => 'available'
            ],
            (object)[
                'id' => 2,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'status' => 'borrowed'
            ],
        ]);

        // This looks for resources/views/books/index.blade.php
        return view('books.index', compact('books'));
    }
}