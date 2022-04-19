<?php

namespace App\Enums;

enum NoteStatus : int
{
    case PRIVATE = 1;
    case PUBLIC = 2;

    public function getName() : string
    {
        return match ($this) {
            self::PRIVATE => 'Private',
            self::PUBLIC => 'Public',
            default => 'Status Not Found',
        };
    }

    public function getStyles() : string
    {
        return match ($this) {
            self::PRIVATE => 'bg-yellow-200 text-yellow-800',
            self::PUBLIC => 'bg-purple-200 text-purple-800',
            default => '',
        };
    }
}
