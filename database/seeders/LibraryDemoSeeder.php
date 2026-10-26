<?php

namespace Database\Seeders;

use App\Enums\BorrowStatus;
use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Member;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Models\Audit;
use RuntimeException;

class LibraryDemoSeeder extends Seeder
{
    public function run(): void
    {
        $covers = collect(Storage::disk('public')->files('covers'))
            ->filter(fn (string $path) => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true))
            ->sort()
            ->values();

        if ($covers->isEmpty()) {
            throw new RuntimeException('No book cover images were found in storage/app/public/covers.');
        }

        DB::transaction(function () use ($covers): void {
            $password = Hash::make('password');

            $admin = User::updateOrCreate(
                ['email' => 'admin@library.test'],
                ['full_name' => 'Library Administrator', 'password' => $password, 'role' => UserRole::ADMIN->value, 'email_verified_at' => now()]
            );
            $librarian = User::updateOrCreate(
                ['email' => 'librarian@library.test'],
                ['full_name' => 'Morgan Lee', 'password' => $password, 'role' => UserRole::LIBRARIAN->value, 'email_verified_at' => now()]
            );

            $categoryData = [
                'Fiction' => ['description' => 'Novels, short stories, and imaginative literature.', 'color' => '#6D5BD0'],
                'Science' => ['description' => 'Popular science, nature, and technology.', 'color' => '#168AAD'],
                'History' => ['description' => 'World history, biographies, and historical studies.', 'color' => '#C56A32'],
                'Technology' => ['description' => 'Computing, engineering, and practical technology.', 'color' => '#3A7D44'],
            ];
            $categories = [];
            foreach ($categoryData as $name => $attributes) {
                $categories[$name] = Category::updateOrCreate(['name' => $name], $attributes);
            }

            $bookData = [
                ['The Silent Library', 'Mira Ellison', 'A young archivist discovers that a missing manuscript is connected to a century-old mystery.', '9780000000001', 352, '2021-04-13', 6, 'Fiction'],
                ['A Map of Small Wonders', 'Jonah Reed', 'An illustrated journey through the overlooked places that shape a city.', '9780000000002', 288, '2019-09-03', 4, 'Fiction'],
                ['The Long Way Home', 'Amara Bennett', 'Three siblings retrace their family history across a changing landscape.', '9780000000003', 416, '2023-02-21', 5, 'Fiction'],
                ['The Ocean Inside Us', 'Dr. Lena Ortiz', 'A clear introduction to the oceans and the ecosystems that sustain life.', '9780000000004', 304, '2020-06-09', 3, 'Science'],
                ['Everyday Astronomy', 'Samuel Park', 'A practical guide to observing the night sky from your own neighborhood.', '9780000000005', 240, '2022-11-15', 5, 'Science'],
                ['The Living Forest', 'Nadia Cole', 'Stories and research reveal the intricate communities found in forests.', '9780000000006', 328, '2018-05-22', 4, 'Science'],
                ['Letters from the Archive', 'Peter Walsh', 'A historian follows a collection of letters through a turbulent decade.', '9780000000007', 376, '2017-01-10', 3, 'History'],
                ['Cities Through Time', 'Ruth Haddad', 'How trade, migration, and design transformed several historic cities.', '9780000000008', 432, '2021-08-17', 4, 'History'],
                ['The Makers of Modern Science', 'Elliot James', 'Profiles of the people and ideas behind major scientific breakthroughs.', '9780000000009', 352, '2024-03-05', 2, 'History'],
                ['Building Better Software', 'Priya Nair', 'A hands-on guide to designing maintainable applications and teams.', '9780000000010', 392, '2022-03-29', 6, 'Technology'],
                ['The Thoughtful Web', 'Caleb Martin', 'Principles for creating accessible, resilient, and user-friendly websites.', '9780000000011', 264, '2020-10-06', 3, 'Technology'],
                ['Data in the Real World', 'Yuki Tanaka', 'A friendly introduction to collecting, understanding, and communicating data.', '9780000000012', 312, '2023-07-18', 5, 'Technology'],
            ];

            $books = [];
            foreach ($bookData as $index => [$title, $author, $description, $isbn, $pages, $publicationDate, $stock, $category]) {
                $books[$isbn] = Book::updateOrCreate(
                    ['isbn' => $isbn],
                    [
                        'title' => $title,
                        'author' => $author,
                        'description' => $description,
                        'number_of_pages' => $pages,
                        'cover_image' => basename($covers[$index % $covers->count()]),
                        'publication_date' => $publicationDate,
                        'stock' => $stock,
                        'category_id' => $categories[$category]->id,
                    ]
                );
            }

            $memberData = [
                ['Avery Brooks', 'avery.brooks@example.test', '14 Cedar Street, Rabat', 'AB123456', '+212600000101'],
                ['Noor El Amrani', 'noor.elamrani@example.test', '28 Olive Avenue, Salé', 'NE234567', '+212600000102'],
                ['Lina Haddad', 'lina.haddad@example.test', '6 Garden Road, Casablanca', 'LH345678', '+212600000103'],
                ['Omar Bennett', 'omar.bennett@example.test', '51 Atlas Lane, Fes', 'OB456789', '+212600000104'],
                ['Sofia Martin', 'sofia.martin@example.test', '9 Palm Square, Tangier', 'SM567890', '+212600000105'],
                ['Youssef Karim', 'youssef.karim@example.test', '73 River Walk, Meknes', 'YK678901', '+212600000106'],
            ];
            $members = [];
            foreach ($memberData as [$name, $email, $address, $cnie, $phone]) {
                $members[$email] = Member::updateOrCreate(
                    ['email' => $email],
                    ['full_name' => $name, 'adress' => $address, 'cnie' => $cnie, 'phone_number' => $phone, 'user_id' => $librarian->id]
                );
            }

            foreach ($members as $member) {
                DB::table('user_member')->updateOrInsert(
                    ['id_user' => $librarian->id, 'id_member' => $member->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            $borrowData = [
                ['avery.brooks@example.test', '9780000000001', 18, 4, null, BorrowStatus::BORROWED],
                ['noor.elamrani@example.test', '9780000000004', 16, 2, null, BorrowStatus::BORROWED],
                ['lina.haddad@example.test', '9780000000007', 35, 14, 20, BorrowStatus::RETURNED],
                ['omar.bennett@example.test', '9780000000010', 24, 10, null, BorrowStatus::OVERDUE],
                ['sofia.martin@example.test', '9780000000002', 12, 2, 8, BorrowStatus::RETURNED],
                ['youssef.karim@example.test', '9780000000011', 8, 1, null, BorrowStatus::CANCELED],
            ];
            $borrows = [];
            foreach ($borrowData as [$memberEmail, $isbn, $borrowedDaysAgo, $dueDaysAgo, $returnedDaysAgo, $status]) {
                $borrowedAt = now()->startOfDay()->subDays($borrowedDaysAgo);
                $borrows[] = Borrow::updateOrCreate(
                    ['member_id' => $members[$memberEmail]->id, 'book_id' => $books[$isbn]->id, 'borrowed_at' => $borrowedAt],
                    [
                        'due_date' => now()->startOfDay()->subDays($dueDaysAgo),
                        'returned_at' => $returnedDaysAgo === null ? null : now()->startOfDay()->subDays($returnedDaysAgo),
                        'status' => $status->value,
                        'is_modified' => $status === BorrowStatus::RETURNED,
                    ]
                );
            }

            $reviewData = [
                ['avery.brooks@example.test', '9780000000001', 5, 'A warm, clever story with a mystery that kept me turning pages.'],
                ['noor.elamrani@example.test', '9780000000004', 4, 'An engaging introduction to ocean science.'],
                ['lina.haddad@example.test', '9780000000007', 5, 'The historical details and letters bring the period to life.'],
                ['omar.bennett@example.test', '9780000000010', 4, 'Useful advice and examples for building software with a team.'],
                ['sofia.martin@example.test', '9780000000002', 3, 'A pleasant read with beautiful observations.'],
                ['youssef.karim@example.test', '9780000000011', 5, 'Thoughtful, practical, and refreshingly accessible.'],
            ];
            foreach ($reviewData as [$memberEmail, $isbn, $rating, $description]) {
                Review::updateOrCreate(
                    ['member_id' => $members[$memberEmail]->id, 'book_id' => $books[$isbn]->id],
                    ['rating' => $rating, 'description' => $description]
                );
            }

            $this->seedAudit($admin, 'Category', $categories['Fiction']->id, 'Fiction category added to the demo library.');
            $this->seedAudit($admin, 'Book', $books['9780000000001']->id, 'The Silent Library added to the demo catalog.');
            $this->seedAudit($librarian, 'Member', $members['avery.brooks@example.test']->id, 'Avery Brooks added as a demo member.');
            $this->seedAudit($librarian, 'Borrow', $borrows[0]->id, 'The Silent Library borrowed by Avery Brooks.');
        });
    }

    private function seedAudit(User $user, string $type, int $auditableId, string $description): void
    {
        Audit::updateOrCreate(
            ['auditable_type' => $type, 'auditable_id' => $auditableId, 'event' => 'created', 'tags' => 'demo-seed'],
            [
                'user_id' => $user->id,
                'user_type' => $user->role->label(),
                'user_name' => $user->full_name,
                'new_values' => ['description' => $description],
            ]
        );
    }
}
