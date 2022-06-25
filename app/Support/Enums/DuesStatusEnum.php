<?php

namespace App\Support\Enums;

enum DuesStatusEnum :string
{
    case PAID = 'PAID';
    case CANCELLED = 'CANCELLED';
    case WAITING_CONFIRMATION = 'WAITING_CONFIRMATION';
}
