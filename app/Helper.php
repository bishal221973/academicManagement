<?php

use App\Models\MySetting;

if (!function_exists('test')) {
    function saveDate($date) {
        $settings = MySetting::where('key','date_type')->first();
        $type='ad';

        if($settings){
            $type=$settings->value;
        }

        if($type=='ad'){
            
        }else{
            return $date;
        }
    }
}