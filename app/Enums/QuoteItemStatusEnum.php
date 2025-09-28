<?php

namespace App\Enums;

enum QuoteItemStatusEnum: string
{
    case Quoted = 'quoted';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Ordered = 'ordered';
    case Cancelled = 'cancelled';
    case Shipped = 'shipped';
    case Delivered = 'delivered';

    public function colour(): string {
        return match($this) {
            self::Quoted => 'yellow',
            self::Approved, self::Shipped, self::Ordered => 'blue',
            self::Rejected, self::Cancelled => 'red',
            self::Delivered => 'green',
        };
    }

    public function labelClass(): string {
        return match($this) {
            self::Quoted => 'bg-yellow-100 text-yellow-800',
            self::Approved, self::Shipped, self::Ordered => 'bg-blue-100 text-blue-800',
            self::Rejected, self::Cancelled => 'bg-red-100 text-red-800',
            self::Delivered => 'bg-green-100 text-green-800',
        };
    }
}
