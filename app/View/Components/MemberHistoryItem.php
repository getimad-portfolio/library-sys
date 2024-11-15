<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MemberHistoryItem extends Component
{
    public $borrow;
    public function __construct($borrow)
    {
        $this->borrow = $borrow;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member-history-item');
    }
}
