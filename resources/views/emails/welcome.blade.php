<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Mail</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9;">
    
    <div style="background: white; width: full; margin: auto; padding: 30px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        @php
            $student=App\Models\Student::find($studentId)->load('course');
            $tutionFees=App\Models\BillItem::where('bill_id',$billId)->where('student_id',$studentId)->where('title','Tution Fees')->first();
            $admissionFees=App\Models\BillItem::where('bill_id',$billId)->where('student_id',$studentId)->where('title','Admisstion Fees')->first();
            $bill=App\Models\Bill::find($billId);
            $setting=App\Models\MySetting::query();

            $finalTemplate = str_replace('{{student_name}}', $student->name, $template);
            $finalTemplate = str_replace('{{course_name}}', $student->course->name, $finalTemplate);
            $finalTemplate = str_replace('{{registration_number}}', $student->registration_number, $finalTemplate);
            $finalTemplate = str_replace('{{registration_date}}', $student->registration_date, $finalTemplate);
            $finalTemplate = str_replace('{{admission_fee}}', $admissionFees?->amount, $finalTemplate);
            $finalTemplate = str_replace('{{monthly_fee}}', $tutionFees?->amount, $finalTemplate);
            $finalTemplate = str_replace('{{discount_amount}}', $bill?->discount, $finalTemplate);
            $finalTemplate = str_replace('{{tax_amount}}', $bill?->total_tax, $finalTemplate);
            $finalTemplate = str_replace('{{total_amount}}', $bill?->total_amount, $finalTemplate);

            $finalTemplate = str_replace('{{contact_number}}', $setting->where('key','academy_contact_no')->first()?->value, $finalTemplate);
            $finalTemplate = str_replace('{{academy_name}}', $setting->where('key','academy_name')->first()?->value, $finalTemplate);
            $finalTemplate = str_replace('{{address}}', $setting->where('key','address')->first()?->value, $finalTemplate);
        @endphp

        {!! $finalTemplate !!}
    </div>

</body>
</html>
