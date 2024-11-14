<?php

namespace App\Observers;
use OwenIt\Auditing\Models\Audit;
use App\Models\User;

class AuditObserver
{
    public function creating(Audit $audit)
    {
        $audit->auditable_type = class_basename($audit->auditable_type);
        if ($audit->user_id) {
            $user = User::find($audit->user_id);
            $audit->user_name = $user ? $user->full_name : null;
            $audit->user_type = $user ? $user->role->label() : null;
        }
    }
}
