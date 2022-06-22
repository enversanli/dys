<?php

namespace App\Support\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case BANNED = 'BANNED';
    case PENDING = 'PENDING';
    case FORGOT_PASSWORD = 'FORGOT_PASSWORD';
    case MAIL_VERIFICATION = 'MAIL_VERIFICATION';
    case TEACHER_CONFIRMATION = 'TEACHER_CONFIRMATION';

    public function all()
    {
        return self::cases();
    }
}
