<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookItem extends Component
{
    public $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function render(): View|Closure|string
    {
        return view('components.book-item');
    }
}
