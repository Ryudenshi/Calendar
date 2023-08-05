<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EventReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;

        
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build(User $email)
    {
        $email->email = Auth::user()->email;

        return $this->from('nigga@gmail.com')
            ->to($email)
            ->subject('Event Reminder')
            ->view('emails.event_reminder', ['event' => $this->event]);
    }
}
