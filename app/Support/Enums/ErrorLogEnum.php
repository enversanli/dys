<?php

namespace App\Support\Enums;

enum ErrorLogEnum:string
{
    // Auth
    case LOGIN_REPOSITORY_ERROR  = 'LOGIN_REPOSITORY_ERROR';
    case RESET_PASSWORD_AUTH_REPOSITORY_ERROR = 'RESET_PASSWORD_AUTH_REPOSITORY_ERROR';
    case FORGOT_PASSWORD_AUTH_REPOSITORY_ERROR = 'FORGOT_PASSWORD_AUTH_REPOSITORY_ERROR';


    // User
    case GET_USER_USERS_REPOSITORY = 'GET_USER_USERS_REPOSITORY';
    case STORE_USER_REPOSITORY_ERROR = 'STORE_USER_REPOSITORY_ERROR';

    // Association
    case STORE_ASSOCIATION_REPOSITORY_ERROR = 'STORE_ASSOCIATION_REPOSITORY_ERROR';

    // Student Class
    case GET_STUDENT_CLASS_REPOSITORY_ERROR = 'GET_STUDENT_CLASS_REPOSITORY_ERROR';
    case STORE_STUDENT_CLASS_REPOSITORY_ERROR = 'STORE_STUDENT_CLASS_REPOSITORY_ERROR';
    case UPDATE_STUDENT_CLASS_REPOSITORY_ERROR = 'UPDATE_STUDENT_CLASS_REPOSITORY_ERROR';
    case DESTROY_STUDENT_CLASS_REPOSITORY_ERROR = 'DESTROY_STUDENT_CLASS_REPOSITORY_ERROR';

    //  Students
    case UPDATE_STUDENT_REPOSITORY_ERROR = 'UPDATE_STUDENT_REPOSITORY_ERROR';
    case DESTROY_STUDENT__REPOSITORY_ERROR = 'DESTROY_STUDENT__REPOSITORY_ERROR';
    case GET_STUDENT_LIST_REPOSITORY_ERROR = 'GET_STUDENT_LIST_REPOSITORY_ERROR';
    case GET_STUDENT_BY_ID_REPOSITORY_ERROR = 'GET_STUDENT_BY_ID_REPOSITORY_ERROR';
    case STORE_STUDENT_REPOSITORY_ERROR = 'STORE_STUDENT_REPOSITORY_ERROR';


    // User
    case DESTROY_USER__REPOSITORY_ERROR = 'DESTROY_USER__REPOSITORY_ERROR';


    // User Role
    case GET_USER_ROLES_REPOSITORY_ERROR = 'GET_USER_ROLES_REPOSITORY_ERROR';
}
