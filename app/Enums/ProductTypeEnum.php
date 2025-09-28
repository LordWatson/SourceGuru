<?php

namespace App\Enums;

enum ProductTypeEnum: string
{
    case Bespoke = 'bespoke';
    case Product = 'catalogue';
    case Package = 'package';

    public function hoverColour(): string {
        return match($this) {
            self::Bespoke => 'hover:bg-gray-100',
            self::Product => 'hover:bg-green-100',
            self::Package => 'hover:bg-blue-100',
        };
    }
}
