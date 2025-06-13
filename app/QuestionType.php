<?php

namespace App;

enum QuestionType: string
{
    case MULTIPLE_CHOICE = 'multiple_choice';
    case ESSAY = 'essay';
    case SHORT_ESSAY = 'short_essay';
    case TRUE_FALSE = 'true_false';

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::MULTIPLE_CHOICE->value => 'Multiple Choice',
            self::ESSAY->value => 'Essay',
            self::SHORT_ESSAY->value => 'Short Essay',
            self::TRUE_FALSE->value => 'True/False',
            default => 'Unknown',
        };
    }

    public static function options(): array
    {
        return [
            self::MULTIPLE_CHOICE->value => 'Multiple Choice',
            self::ESSAY->value => 'Essay',
            self::SHORT_ESSAY->value => 'Short Essay',
            self::TRUE_FALSE->value => 'True/False',
        ];
    }
}
