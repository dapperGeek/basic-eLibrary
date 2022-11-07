<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CheckOut;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function newBook()
    {
        $this->pageAuthorizationGuard();

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
        $data['checkStatus'] = CheckOut::where('user_id', auth()->user()->id)
                    ->where('book_id', $id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->first();
        return view('books.read', $data);
    }

    //Opens page with form to add new book
    public function edit($id)
    {
        $this->pageAuthorizationGuard();
        
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

    //Checks user authorization level
    public function pageAuthorizationGuard()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Unauthorized action');
        }
    }

    //Checks out book
    public function checkOutBook(Request $request)
    {
        $checkOutDate = date('Y-m-d H:i:s', time());
        $dateObj = new DateTime($checkOutDate);
        $returnDateObj = $dateObj->add(new DateInterval('P10D'));
        $expectedDate = $returnDateObj->format('Y-m-d H:i:s');

        $checkOutData = [
            'user_id' => auth()->user()->id,
            'book_id' => $request->book_id,
            'check_out_date' => $checkOutDate,
            'expected_date' => $expectedDate,
            'check_out_status' => 0
        ];

        $checkOut = CheckOut::create($checkOutData);

        return back()->with('message', 'Book checked out');
    }

    //Check in book
    public function CheckInBook(Request $request)
    {
        $checkOutStatus = CheckOut::find($request->check_out_id);

        $checkOutStatus->check_out_status = 1;
        $checkOutStatus->check_in_date = date('Y-m-d H:i:s', time());
        $checkOutStatus->save();

        return back();
    }

    //Retrieves & displays checked out books
    public function checkedOutBooks()
    {
        $this->pageAuthorizationGuard();

        $data = [];
        $data['pageHeader'] = 'Books List';
        $data['crumbSuffix'] = 'Library';

        $checkedOutBooks = DB::table('check_outs')
        ->join('books', 'check_outs.book_id', '=', 'books.id')
        ->join('users', 'check_outs.user_id', '=', 'users.id')
        ->select('check_outs.*', 'check_outs.id AS sort_id', 'users.*', 'books.*')
        ->where('check_outs.check_out_status', '!=', 1)
        ->get();

        $data['books'] = $checkedOutBooks;

        return view('books.checked-out', $data);
    }

    public function sanitizeFormDate($formDate)
    {
        # code...
    }
}
