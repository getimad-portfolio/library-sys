<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class BookItem extends Component
{
    public $header;
    public $author;
    public $description;
    public $isbn;
    public $numberOfPages;
    public $image;
    public $category;
    public $bookId;

    public function __construct($header, $author, $description, $isbn, $numberOfPages, $category, $image, $bookId)
    {
        $this->header = $header;
        $this->author = $author;
        $this->description = $description;
        $this->isbn = $isbn;
        $this->numberOfPages = $numberOfPages;
        $this->image = Storage::url("covers/{$image}");
        $this->category = $category;
        $this->bookId = $bookId;
    }

    public function render(): View|Closure|string
    {
        return view('components.book-item');
    }
}
