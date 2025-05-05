<?php

namespace App\Enums;

enum QuoteStatusEnum: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Shipped = 'shipped';
    case Rejected = 'rejected';
    case Expired = 'expired';
    case Completed = 'completed';

    public function colour(): string {
        return match($this) {
            QuoteStatusEnum::Draft, QuoteStatusEnum::Sent => 'yellow',
            QuoteStatusEnum::Accepted, QuoteStatusEnum::Shipped => 'blue',
            QuoteStatusEnum::Rejected, QuoteStatusEnum::Expired => 'red',
            QuoteStatusEnum::Completed => 'green',
        };
    }

    public function labelClass(): string {
        return match($this) {
            QuoteStatusEnum::Draft, QuoteStatusEnum::Sent => 'bg-yellow-100 text-yellow-800',
            QuoteStatusEnum::Accepted, QuoteStatusEnum::Shipped => 'bg-blue-100 text-blue-800',
            QuoteStatusEnum::Rejected, QuoteStatusEnum::Expired => 'bg-red-100 text-red-800',
            QuoteStatusEnum::Completed => 'bg-green-100 text-green-800',
        };
    }
}
