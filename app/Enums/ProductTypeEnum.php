<?php

namespace App\Enums;

enum ProductTypeEnum: string
{
    case Bespoke = 'bespoke';
    case Product = 'catalogue';
    case Package = 'package';

    public function hoverColour(): string {
        return match($this) {
            ProductTypeEnum::Bespoke => 'hover:bg-gray-100',
            ProductTypeEnum::Product => 'hover:bg-green-100',
            ProductTypeEnum::Package => 'hover:bg-blue-100',
        };
    }
}
