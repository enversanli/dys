<?php

namespace App\Support\Enums;

enum ErrorLogEnum:string
{
    // Auth
    case LOGIN_REPOSITORY_ERROR  = 'LOGIN_REPOSITORY_ERROR';

    // User
    case STORE_USER_REPOSITORY_ERROR = 'STORE_USER_REPOSITORY_ERROR';

    // Association
    case STORE_ASSOCIATION_REPOSITORY_ERROR = 'STORE_ASSOCIATION_REPOSITORY_ERROR';

    // Student Class
    case GET_STUDENT_CLASS_REPOSITORY_ERROR = 'GET_STUDENT_CLASS_REPOSITORY_ERROR';
    case STORE_STUDENT_CLASS_REPOSITORY_ERROR = 'STORE_STUDENT_CLASS_REPOSITORY_ERROR';
}
