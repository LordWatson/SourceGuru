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
            QuoteItemStatusEnum::Quoted => 'yellow',
            QuoteItemStatusEnum::Approved, QuoteItemStatusEnum::Shipped, QuoteItemStatusEnum::Ordered => 'blue',
            QuoteItemStatusEnum::Rejected, QuoteItemStatusEnum::Cancelled => 'red',
            QuoteItemStatusEnum::Delivered => 'green',
        };
    }

    public function labelClass(): string {
        return match($this) {
            QuoteItemStatusEnum::Quoted => 'bg-yellow-100 text-yellow-800',
            QuoteItemStatusEnum::Approved, QuoteItemStatusEnum::Shipped, QuoteItemStatusEnum::Ordered => 'bg-blue-100 text-blue-800',
            QuoteItemStatusEnum::Rejected, QuoteItemStatusEnum::Cancelled => 'bg-red-100 text-red-800',
            QuoteItemStatusEnum::Delivered => 'bg-green-100 text-green-800',
        };
    }
}
