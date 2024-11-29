<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $totalStock = Book::sum('stock');

        $totalBorrowed = Borrow::where('status', 'borrowed')
            ->whereDate('updated_at', Carbon::today())->count();

        $totalReturned = Borrow::where('status', 'returned')
            ->whereDate('updated_at', Carbon::today())->count();

        return view('dashboards.librarian', compact('totalStock', 'totalBorrowed', 'totalReturned'));
    }
}
