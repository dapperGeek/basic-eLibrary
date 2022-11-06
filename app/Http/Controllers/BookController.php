<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //Displays books list
    public function index()
    {
        $data = [];
        $data['pageHeader'] = 'Books List';
        $data['crumbSuffix'] = 'Library';
        $data['books'] = Book::all();
        return view('index', $data);
    }

    //Opens page with form to add new book
    public function book()
    {
        $data = [];
        $data['pageHeader'] = 'Books List';
        $data['crumbSuffix'] = 'Library';
        return view('books.create', $data);
    }

    //Adds new book to database
    public function addBook(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'revision_number' => 'required',
            'isbn' => 'required',
            'published_date' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'synopsis' => 'required',
            'genre' => 'required'
        ]);

        $formFields['published_date'] = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $formFields['published_date'])));

        $formFields['added_date'] = date('Y-m-d 00:00:00', time());

        if ($request->hasFile('cover_image')) {
            $formFields['cover_image'] = $request->file('cover_image')->store('cover-images', 'public');
        }

        $book = Book::create($formFields);

        return redirect('/')->with('message', $book->title . ' successfully added to library');
    }

    //Displays selected book
    public function displayBook($id)
    {
        $data = [];
        $data['pageHeader'] = 'Books List';
        $data['crumbSuffix'] = 'Library';
        $data['book'] = Book::where('id', $id)->first();
        return view('books.read', $data);
    }

    //Opens page with form to add new book
    public function edit($id)
    {
        $data = [];
        $data['pageHeader'] = 'Books List';
        $data['crumbSuffix'] = 'Library';
        $data['book'] = Book::where('id', $id)->first();

        return view('books.edit', $data);
    }

    //Updates book
    public function updateBook(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'revision_number' => 'required',
            'isbn' => 'required',
            'published_date' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'synopsis' => 'required',
            'genre' => 'required'
        ]);

        $formFields['published_date'] = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $formFields['published_date'])));

        // $formFields['added_date'] = date('Y-m-d 00:00:00', time());

        if ($request->hasFile('cover_image')) {
            $formFields['cover_image'] = $request->file('cover_image')->store('cover-images', 'public');
        }

        $book = Book::where('id', $request->id)->update($formFields);

        return redirect('/book/' . $request->id)->with('message', $request->title . ' successfully updated');
    }

}
