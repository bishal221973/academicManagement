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

        if ($type === 'ad') {
            return ad_to_bs($date);
        }

        return $date;
    }
}

if (!function_exists('ad_to_bs')) {
    function ad_to_bs($engDate) {
        if(!$engDate){
            return LaravelNepaliDate::from($engDate)->toNepaliDate();
        }
    }
}

if (!function_exists('bs_to_ad')) {
    function bs_to_ad($nepDate) {
        if(!$nepDate){
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
            // Convert $date to string safely before passing to bs_to_ad()
            return bs_to_ad((string) $date);
        }

        // If type is 'bs' or anything else, return as is
        return $date;
    }
}

