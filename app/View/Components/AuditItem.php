<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use OwenIt\Auditing\Models\Audit;

class AuditItem extends Component
{
    public $audit;
    /**
     * Create a new component instance.
     */
    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.audit-item');
    }
}
