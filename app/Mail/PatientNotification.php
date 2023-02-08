<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $phone;
    public $problem;
    public function __construct($name, $phone, $problem)
    {
        $this->name    = $name;
        $this->phone   = $phone;
        $this->problem = $problem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            "name"    => $this->name,
            "phone"   => $this->phone,
            "problem" => $this->problem,
        ];
        return $this
            ->subject('Patient Appointment notification')
            ->markdown('mail.message', compact("data"));
    }
}
