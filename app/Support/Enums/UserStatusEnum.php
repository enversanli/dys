<?php

namespace App\Support\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case BANNED = 'BANNED';
    case FORGOT_PASSWORD = 'FORGOT_PASSWORD';
    case MAIL_VERIFICATION = 'MAIL_VERIFICATION';

    public function all()
    {
        return self::cases();
    }
}
