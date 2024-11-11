<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MemberItem extends Component
{
    public $memberId;
    public $fullName;
    public $email;
    public $cnie;
    public $phoneNumber;
    
    public function __construct($fullName, $email, $cnie, $phoneNumber, $memberId)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->cnie = $cnie;
        $this->phoneNumber = $phoneNumber;
        $this->memberId = $memberId;
    }

    public function render(): View|Closure|string
    {
        return view('components.member-item');
    }
}
