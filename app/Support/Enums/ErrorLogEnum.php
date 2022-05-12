<?php

namespace App\Support\Enums;

enum ErrorLogEnum:string
{
    // User
    case STORE_USER_REPOSITORY_ERROR = 'STORE_USER_REPOSITORY_ERROR';


    // Association
    case STORE_ASSOCIATION_REPOSITORY_ERROR = 'STORE_ASSOCIATION_REPOSITORY_ERROR';
}
