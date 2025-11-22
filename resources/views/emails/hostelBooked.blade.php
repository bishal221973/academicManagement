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
            $hostel=App\Models\Hostel::find($hostel_id);
            $hostelStudent=App\Models\HostelStudent::find($hostelStudentID)->load('room');
            
            $finalTemplate = str_replace('{{student_name}}', $student->name, $template);
            $finalTemplate = str_replace('{{hostel_name}}', $hostel->name, $finalTemplate);
            $finalTemplate = str_replace('{{room_number}}', $hostelStudent->room?->name, $finalTemplate);
            $finalTemplate = str_replace('{{bed_number}}', $hostelStudent->bed_no, $finalTemplate);
            $finalTemplate = str_replace('{{check_in_date}}', $hostelStudent?->check_in_date, $finalTemplate);
            $finalTemplate = str_replace('{{check_out_date}}', $hostelStudent?->check_out_date, $finalTemplate);
        @endphp

        {!! $finalTemplate !!}
    </div>

</body>
</html>
