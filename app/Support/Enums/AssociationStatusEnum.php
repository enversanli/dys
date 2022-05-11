<?php

namespace App\Support\Enums;

enum AssociationStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case BANNED = 'BANNED';
    case WAITING_CREATOR_MAIL_VERIFICATION = 'WAITING_CREATOR_MAIL_VERIFICATION';

    public function all()
    {
        return self::cases();
    }
}
