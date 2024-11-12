<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BorrowItem extends Component
{
    public $borrowed_at;
    public $due_date;
    public $returned_at;
    public $status;
    public $isbn;
    public $cnie;
    public $borrowId;

    public function __construct($status, $isbn, $cnie, $borrowId, $borrowed_at = null, $due_date = null, $returned_at = null)
    {
        $this->borrowed_at = $borrowed_at;
        $this->due_date = $due_date;
        $this->returned_at = $returned_at;
        $this->status = $status;
        $this->isbn = $isbn;
        $this->cnie = $cnie;
        $this->borrowId = $borrowId;
    }

    public function render(): View|Closure|string
    {
        return view('components.borrow-item');
    }
}
