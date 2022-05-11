<?php

namespace App\Support\Enums;

enum AssociationStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case BANNED = 'BANNED';

    public function all()
    {
        return self::cases();
    }
}
