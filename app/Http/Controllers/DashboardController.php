<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Book;

class DashboardController extends Controller
{
    public function index()
    {
        $topBooks = Book::select('books.isbn', DB::raw('COUNT(borrows.id) as borrow_count'))
            ->leftJoin('borrows', 'borrows.book_id', '=', 'books.id')
            ->groupBy('books.id')
            ->orderByDesc('borrow_count')
            ->limit(10)
            ->get();

        $topCategories = DB::table('categories')
            ->select('categories.name', DB::raw('COUNT(borrows.id) as borrow_count'))
            ->leftJoin('books', 'books.category_id', '=', 'categories.id')
            ->leftJoin('borrows', 'borrows.book_id', '=', 'books.id')
            ->groupBy('categories.id')
            ->orderByDesc('borrow_count')
            ->get();

        $topMembers = DB::table('members')
            ->select('members.cnie', DB::raw('COUNT(borrows.id) as borrow_count'))
            ->leftJoin('borrows', 'borrows.member_id', '=', 'members.id')
            ->groupBy('members.id')
            ->orderByDesc('borrow_count')
            ->get();

        return view('dashboard', compact('topBooks', 'topCategories', 'topMembers'));
    }
}
