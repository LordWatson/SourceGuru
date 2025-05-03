<?php

namespace App\Enums;

enum QuoteStatusEnum: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired = 'expired';
    case Completed = 'completed';

    public function colour(): string {
        return match($this) {
            QuoteStatusEnum::Draft, QuoteStatusEnum::Sent => 'yellow',
            QuoteStatusEnum::Accepted => 'blue',
            QuoteStatusEnum::Rejected, QuoteStatusEnum::Expired => 'red',
            QuoteStatusEnum::Completed => 'green',
        };
    }
}
