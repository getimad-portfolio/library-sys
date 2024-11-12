<?php

namespace App\Enums;

enum BorrowStatus: string {
    case CANCELED = 'canceled';
    case BORROWED = 'borrowed';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';

    public function label(): string {
        return match ($this) {
            self::CANCELED => 'Canceled',
            self::BORROWED => 'Borrowed',
            self::RETURNED => 'Returned',
            self::OVERDUE => 'Overdue'
        };
    }
}