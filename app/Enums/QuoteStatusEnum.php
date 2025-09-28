<?php

namespace App\Enums;

use App\Models\Quote;

enum QuoteStatusEnum: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Shipped = 'shipped';
    case Rejected = 'rejected';
    case Expired = 'expired';
    case Completed = 'completed';
    case Ordered = 'ordered';

    public function colour(): string {
        return match($this) {
            self::Draft, self::Sent => 'yellow',
            self::Accepted, self::Shipped => 'blue',
            self::Rejected, self::Expired => 'red',
            self::Completed, self::Ordered => 'green',
        };
    }

    public function labelClass(): string {
        return match($this) {
            self::Draft, self::Sent => 'bg-yellow-100 text-yellow-800',
            self::Accepted, self::Shipped => 'bg-blue-100 text-blue-800',
            self::Rejected, self::Expired => 'bg-red-100 text-red-800',
            self::Completed, self::Ordered => 'bg-green-100 text-green-800',
        };
    }

    public function display(): string
    {
        return ucfirst($this->value);
    }

    public function statusBlock(Quote $quote): array
    {
        $display = $this->display();

        return match ($this) {
            self::Completed => [
                'label' => 'Completed',
                'content' => $quote->completed_date,
            ],
            self::Expired => [
                'label' => 'Expires In',
                'content' => $display,
            ],
            self::Draft, self::Sent => [
                'label' => 'Expires In',
                'content' => $quote->expires_in . ' days',
            ],
            default => [
                'label' => $display,
                'content' => $display,
            ],
        };
    }


}
