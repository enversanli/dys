<?php

namespace App\Support\Enums;

enum UserRoleKeyEnum: string
{
    case ADMIN = 'admin';
    case PARENT = 'parent';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case ASSOCIATION_MANAGER = 'association_manager';
    case SUB_ASSOCIATION_MANAGER = 'sub_association_manager';

    public function all(){
        return self::cases();
    }

    public function KeyAndValue(){
        return [

        ];
    }

    public static function getValue($key){
        return self::getValue($key);
    }
}
