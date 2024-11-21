<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Book;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Top

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
            ->limit(10)
            ->get();

        $topMembers = DB::table('members')
            ->select('members.cnie', DB::raw('COUNT(borrows.id) as borrow_count'))
            ->leftJoin('borrows', 'borrows.member_id', '=', 'members.id')
            ->groupBy('members.id')
            ->orderByDesc('borrow_count')
            ->limit(10)
            ->get();

        // charts

        $books = DB::table('books as b1')
            ->join('books as b2', 'b1.id', '=', 'b2.id')
            ->select(DB::raw('DATE(b1.created_at) as created_date'), DB::raw('COUNT(b1.id) as book_count'))
            ->where('b1.created_at', '>=', now()->subDays(30))
            ->groupBy('created_date')
            ->orderBy('created_date')
            ->limit(30)
            ->get();

        $booksChart = [
            'labels' => $books->pluck('created_date')->map(fn($date) => \Carbon\Carbon::parse($date)->toDateString()),
            'data' => $books->pluck('book_count'),
        ];

        $members = DB::table('members as m1')
            ->join('members as m2', 'm1.id', '=', 'm2.id')
            ->select(DB::raw('DATE(m1.created_at) as created_date'), DB::raw('COUNT(m1.id) as member_count'))
            ->where('m1.created_at', '>=', now()->subDays(30))
            ->groupBy('created_date')
            ->orderBy('created_date')
            ->limit(30)
            ->get();

        $membersChart = [
            'labels' => $members->pluck('created_date')->map(fn($date) => \Carbon\Carbon::parse($date)->toDateString()),
            'data' => $members->pluck('member_count')
        ];

        $borrows = DB::table('borrows as b1')
            ->join('borrows as b2', 'b1.id', '=', 'b2.id')
            ->select(DB::raw('DATE(b1.created_at) as created_date'), DB::raw('COUNT(b1.id) as borrow_count'))
            ->where('b1.created_at', '>=', now()->subDays(30))
            ->groupBy('created_date')
            ->orderBy('created_date')
            ->limit(30)
            ->get();
        
        $borrowsChart = [
            'labels' => $borrows->pluck('created_date')->map(fn($date) => \Carbon\Carbon::parse($date)->toDateString()),
            'data' => $borrows->pluck('borrow_count')
        ];

        // Total Stock
        $totalStock = Book::sum('stock');

        return view('dashboards.admin', compact('topBooks', 'topCategories', 'topMembers', 'booksChart', 'membersChart', 'borrowsChart', 'totalStock'));
    }
}
