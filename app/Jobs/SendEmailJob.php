<?php

namespace App\Jobs;

use App\Mail\SendHistoricalDataMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use File;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public $email;

     public $historicalQuotes;

     public $startDate;

     public $endDate;

     public $companyName;






    public function __construct($email , $historicalQuotes, $startDate, $endDate,$companyName)
    {
        $this->email             =$email ;
        $this->historicalQuotes  =$historicalQuotes;
        $this->startDate         =$startDate;
        $this->endDate           =$endDate;
        $this->companyName       =$companyName;
   
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
      $pdf = $this->createPdf();
      $pdfFile =$this->storePdf($pdf);

       Mail::to($this->email)->send(new SendHistoricalDataMail($pdfFile ,$this->startDate,$this->endDate ,$this->companyName));

    }


    protected function createPdf()
    {
        $data['historicalQuotes'] = $this->historicalQuotes;
        $data['startDate']       = $this->startDate;
        $data['endDate']         = $this->endDate;
        $data['companyName']      = $this->companyName;      
        return Pdf::loadView('pdf' , $data)->output();

    }


    protected function storePdf($pdf): string
    {
        $path = time() . '.pdf';
        Storage::put($path, $pdf);

    //   $path =  public_path('/'.$name);
    //    File::put($path, $path );
        return $path;
    }
}
