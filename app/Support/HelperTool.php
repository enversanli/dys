<?php

namespace App\Support;

class HelperTool
{
    public static function logger($error = null){
        activity()
            ->log('Error');
    }
}
