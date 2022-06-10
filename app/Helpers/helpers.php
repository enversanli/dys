<?php
use  Carbon\Carbon;

if (!function_exists('getCurrentTime')){
    function getCurrentTime(){
        return Carbon::now()->format('Y-m-d H:i:s');
    }
}


