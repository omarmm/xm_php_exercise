<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendHistoricalDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $companyName;

    public $startDate;

    public $endDate;

    public $path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $path , $startDate , $endDate , $companyName)
    {
        $this->companyName = $companyName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->path = $path;
        

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')
        ->subject($this->companyName)
        ->attachFromStorage($this->path);
;
    }
}
