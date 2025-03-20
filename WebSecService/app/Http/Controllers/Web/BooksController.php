<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BooksController;


class BooksController extends Controller
{
    // Display all books
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    // Show the form to create a new book
    public function create()
    {
        return view('books.create');
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }
}
