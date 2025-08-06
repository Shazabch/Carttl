<?php

namespace App\Enums;

enum EngineDisplacement: string
{
    case L_1_0 = '1.0';
    case L_1_3 = '1.3';
    case L_1_5 = '1.5';
    case L_1_8 = '1.8';
    case L_2_0 = '2.0';
    case L_2_4 = '2.4';
    case L_2_5 = '2.5';
    case L_2_6 = '2.6';
    case L_3_0 = '3.0';
    case L_3_5 = '3.5';
    case L_4_0 = '4.0';
    case L_5_0 = '5.0';

    public function label(): string
    {
        return $this->value . ' L';
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
