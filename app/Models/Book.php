<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        'author',
        "description",
        "isbn",
        "number_of_pages",
        "cover_image",
        "publication_date",
        "category_id",
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function borrowingMembers() {
        return $this->belongsToMany(Member::class, 'members')
            ->withPivot('borrowed_at', 'due_date', 'returned_at')
            ->withTimestamps();
    }
}
