<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'asc');
        $type = $request->input('type');
        $date = $request->input('date');

        $audits = Audit::
            when($search, function ($query, $search) {
                if ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('user_name', 'like', "%{$search}%");
                    });
                }
            })
            ->when($type, function ($query, $type) {
                if ($type) {
                    $query->where('user_type', $type);
                }
            })
            ->when($date, function ($query, $date) {
                switch ($date) {
                    case ('24h'):
                        $query->where('created_at', '>=', Carbon::now()->subDays(1));
                        break;
                    case ('3d'):
                        $query->where('created_at', '>=', Carbon::now()->subDays(3));
                        break;
                    case ('7d'):
                        $query->where('created_at', '>=', Carbon::now()->subDays(7));
                        break;
                    case ('1m'):
                        $query->where('created_at', '>=', Carbon::now()->subMonths(1));
                        break;
                }
            })
            ->orderBy('created_at', $sort)
            ->get();

        return view('logs.index', compact('audits'));
    }

    public function destroyAll()
    {
        Audit::truncate();

        return view('logs.index');
    }
}
