<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'status' => 'nullable',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (request()->has('from')) {
                $from = request('from');
                $convertedAd = null;
                $convertedBs = null;

                // Try to convert safely
                if (!empty($from)) {
                    if (is_bs_date($from)) {
                        $convertedAd = bs_to_ad($from);
                        $convertedBs = $from;
                    } else {
                        $convertedAd = $from;
                        $convertedBs = ad_to_bs($from);
                    }
                }

                // Always ensure both columns get a non-null value
                $student->from = $convertedAd ?? $from ?? now()->toDateString();
                $student->from_bs = $convertedBs ?? $from ?? now()->toDateString();
            }

            if (request()->has('to')) {
                $to = request('to');
                $convertedAd = null;
                $convertedBs = null;

                if (!empty($to)) {
                    if (is_bs_date($to)) {
                        $convertedAd = bs_to_ad($to);
                        $convertedBs = $to;
                    } else {
                        $convertedAd = $to;
                        $convertedBs = ad_to_bs($to);
                    }
                }

                $student->to = $convertedAd ?? $to ?? now()->toDateString();
                $student->to_bs = $convertedBs ?? $to ?? now()->toDateString();
            }
        });




        function is_bs_date($date)
        {
            // Simple detection: BS years are usually > 2000 and < 2100 + 56 offset
            // Example: 2081-05-14 (BS)
            $year = (int) explode('-', $date)[0];
            return $year > 2050 && $year < 2200; // Adjust this range based on your BS range
        }

        function is_ad_date($date)
        {
            $year = (int) explode('-', $date)[0];
            return $year >= 1900 && $year <= 2100;
        }

        // static::updating(function ($student) {
        //     if (request()->has('registration_date')) {
        //         $student->registration_date = saveDate(request('registration_date'));
        //     }
        //     if (request()->has('birth_date')) {
        //         $student->birth_date = saveDate(request('birth_date'));
        //     }
        // });


    }
}
