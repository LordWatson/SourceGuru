<?php

namespace App\Enums;

enum ProductTypeEnum: string
{
    case Bespoke = 'bespoke';
    case Product = 'product';
    case Package = 'package';
}
