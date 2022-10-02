<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class notifyAdminSalesInvoiceCreated extends Notification
{
    use Queueable;

    protected $mailVariables;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mailVariables)
    {
        $this->mailVariables = $mailVariables;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


    public function IncludePanelDesign($text_body, $panel_type = "")
    {
        return '<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr><td class="panel-content ' . $panel_type . '"><table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr>
<td class="panel-item"><ol>' . $text_body . '</ol></td></tr></table></td></tr></table>';
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $sales_date = Carbon::parse($this->mailVariables->sales_details->sales_at)->format('d-M-Y');
        $conditionBookingTextWithPanel = $this->IncludePanelDesign($this->mailVariables->conditionBookingText, 'danger');
        $amountTextWithPanel = $this->IncludePanelDesign($this->mailVariables->amountText);
        $productTextFoMailWithPanel = $this->IncludePanelDesign($this->mailVariables->productTextFoMail, 'warning');
        $mailMessage = (new MailMessage)
            ->greeting('New sales invoice created')
            ->subject("New sales invoice created ID:# {$this->mailVariables->sales_details->id} Date: {$sales_date} ( {$this->mailVariables->customer_name}) Please Approve")
            ->line($this->mailVariables->notificationText)
            ->line(new HtmlString('<h1>Amount Information</h1>'))
            ->line(new HtmlString($amountTextWithPanel))
            ->line(new HtmlString('<h1>Product Information</h1>'))
            ->line(new HtmlString($productTextFoMailWithPanel));
            if ($this->mailVariables->sales_details->is_condition == true) {
                $mailMessage->line(new HtmlString('<h1>Condition Booking Details</h1>'))
                    ->line(new HtmlString($conditionBookingTextWithPanel));
            }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
