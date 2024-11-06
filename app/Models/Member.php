<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'adress',
        'cnie',
        'phone_number',
        'user_id'
    ];

    public function user() {
        return $this->belongsToMany(User::class, 'user_member', 'member_id', 'user_id');
    }

    public function borrowedBooks() {
        return $this->belongsToMany(Book::class, 'borrows')
            ->withPivot('borrowed_at', 'due_date', 'returned_at')
            ->withTimestamps();
    }
}
