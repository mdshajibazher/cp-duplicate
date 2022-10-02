<?php

namespace App\Jobs;

use App\Mail\SalesInvoiceCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SalesInvoiceCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $mailDetails;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $salesInvoiceCreatedMail = new SalesInvoiceCreated($this->mailDetails);
        Mail::to($this->mailDetails['email'])->send($salesInvoiceCreatedMail);


    }
}
