<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MemberItem extends Component
{
    public $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function render(): View|Closure|string
    {
        return view('components.member-item');
    }
}
