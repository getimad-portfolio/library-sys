<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LibraryDemoSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_library_data_idempotently_with_existing_covers(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('categories', 4);
        $this->assertDatabaseCount('books', 12);
        $this->assertDatabaseCount('members', 6);
        $this->assertDatabaseCount('user_member', 6);
        $this->assertDatabaseCount('borrows', 6);
        $this->assertDatabaseCount('reviews', 6);
        $this->assertDatabaseCount('audits', 4);

        $availableCovers = collect(Storage::disk('public')->files('covers'))
            ->map(fn (string $path) => basename($path));

        foreach (Book::all() as $book) {
            $this->assertContains($book->cover_image, $availableCovers);
        }
    }
}
