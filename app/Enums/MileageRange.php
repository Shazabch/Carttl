<?php

namespace App\Enums;

enum MileageRange: int
{
    case UNDER_10000         = 1;
    case FROM_10000_TO_25000 = 2;
    case FROM_25000_TO_50000 = 3;
    case OVER_50000          = 4;

    public function label(): string
    {
        return match ($this) {
            self::UNDER_10000         => 'Under 10,000 miles',
            self::FROM_10000_TO_25000 => '10,000 – 25,000 miles',
            self::FROM_25000_TO_50000 => '25,000 – 50,000 miles',
            self::OVER_50000          => 'Over 50,000 miles',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
