<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HostelBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
   public $studentId;
    public $billId;
    public $template;
    public $subject;
    public $hostel_id;
    public $hostelStudentID;
    public function __construct($studentId,$hostel_id,$hostelStudentID,$billId, $template, $subject)
    {
        $this->studentId=$studentId;
        $this->billId=$billId;
        $this->template = $template;
        $this->subject=$subject;
        $this->hostel_id=$hostel_id;
        $this->hostelStudentID=$hostelStudentID;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject ?? 'Hostel Booked Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.hostelBooked',
            with: [
                'studentId' => $this->studentId,
                'template' => $this->template,
                'billId'=>$this->billId,
                'hostel_id'=>$this->hostel_id,
                'hostelStudentID'=>$this->hostelStudentID
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
