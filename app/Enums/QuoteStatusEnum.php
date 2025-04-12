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
}
