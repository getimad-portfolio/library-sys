<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Member extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'full_name',
        'email',
        'adress',
        'cnie',
        'phone_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
