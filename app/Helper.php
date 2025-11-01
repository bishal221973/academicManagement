<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use App\Models\MySetting;

if (!function_exists('saveDate')) {
    function saveDate($date) {
        if (empty($date)) {
            return $date;
        }
        $settings = MySetting::where('key', 'date_type')->first();
        $type = 'ad';
        
        if ($settings) {
            $type = $settings->value;
        }
        
        if ($type === 'bs') {
            return ad_to_bs($date);
        }
        
        // dd($date);
        return $date;
    }
}

if (!function_exists('saveFormatedDate')) {
    function saveFormatedDate($date) {
        if (empty($date)) {
            return $date;
        }

        $settings = MySetting::where('key', 'date_type')->first();
        $type = $settings ? $settings->value : 'ad';

        // Detect whether input date is AD or BS
        // Example logic — you can refine based on your actual date format
        $isBs = preg_match('/[0-9]{4}\-[0-9]{2}\-[0-9]{2}/', $date) && intval(explode('-', $date)[0]) < 2100;

        if ($type === 'bs' && !$isBs) {
            // Convert AD to BS
            return ad_to_bs($date);
        } elseif ($type === 'ad' && $isBs) {
            // Convert BS to AD
            return bs_to_ad($date);
        }

        // Already in correct format
        return $date;
    }
}


if (!function_exists('ad_to_bs')) {
    function ad_to_bs($engDate) {
        if($engDate){
            return LaravelNepaliDate::from($engDate)->toNepaliDate();
        }
    }
}

if (!function_exists('bs_to_ad')) {
    function bs_to_ad($nepDate) {
        if($nepDate){
            return LaravelNepaliDate::from($nepDate)->toEnglishDate();
        }
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date) {
        // Return early if date is null or empty
        if (empty($date)) {
            return $date;
        }
        
        $settings = MySetting::where('key', 'date_type')->first();
        $type = 'ad';
        
        if ($settings) {
            $type = $settings->value;
        }
        
        if ($type === 'ad') {
            return $date;
            // Convert $date to string safely before passing to bs_to_ad()
            return bs_to_ad((string) $date);
        }

        // If type is 'bs' or anything else, return as is
        return $date;
    }
}



