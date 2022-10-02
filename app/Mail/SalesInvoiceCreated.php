<?php

namespace App\Mail;

use App\Admin;
use App\GeneralOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Str;

class SalesInvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected  $mailDetails,$PDFLocation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
//        $sale =  $this->mailDetails['sales_details'];
//        $current_user = $this->mailDetails['sales_details']->user;
//        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
//        $general_opt_value = json_decode($general_opt->options, true);
//        $signature = empty($sale->approved_by) ? '' : Admin::where('id', $sale->approved_by)->select('name', 'signature')->first();
//        $pdf = PDF::loadView('pos.sale.invoice', compact('sale', 'current_user', 'general_opt_value', 'signature'));
//        $saveDirPath = 'public/PDF/invoice/';
//        if (!File::isDirectory($saveDirPath)) {
//            File::makeDirectory($saveDirPath, 0777, true, true);
//        }
//        $saveLocationFullPath = $saveDirPath.Str::slug($this->mailDetails['sales_details']->user->name)."-".$this->mailDetails['sales_details']->sales_at->format('d-m-Y')."-".time().'.pdf';
//        $pdf->save($saveLocationFullPath);
//        $this->PDFLocation = $saveLocationFullPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sale = $this->mailDetails['sales_details'];
        $conditionBookingText = $sale->is_condition ? "Condition Booking Amount: $sale->condition_amount" : "";
        $mailText =  "Date: {$sale->sales_at->format('d-m-Y')} Invoice ID:# {$sale->id} Customer:  {$sale->user->name} , Address: {$sale->user->address}  {$this->mailDetails['product_text']}  Subtotal: {$this->mailDetails['subTotal']}  Discount: {$sale->discount}  Grand Total: {$sale->amount} {$conditionBookingText}  Prepared By:" . $this->mailDetails['prepared_by'] . " .Please Approve the Invoice,Thanks";


        return $this->markdown('email.sales_invoice_created', [
            'mailInfo' => ['mailText' => $mailText, 'productText' =>$this->mailDetails['product_text']],
        ])->subject("New sales invoice created ID:# {$this->mailDetails['sales_details']->id} Date: {$this->mailDetails['sales_details']->sales_at->format('d-M-Y')} ( {$this->mailDetails['sales_details']->user->name}) Please Approve");
        //->attach( $this->PDFLocation);
    }
}
