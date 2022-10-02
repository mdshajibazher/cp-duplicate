<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class notifyAdminSalesInvoiceEdited extends Notification
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

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function IncludePanelDesign($text_body, $panel_type="")
    {
        return '<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr><td class="panel-content ' . $panel_type . '"><table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr>
<td class="panel-item"><ol>' . $text_body . '</ol></td></tr></table></td></tr></table>';
    }

    public function toMail($notifiable)
    {
        //panel type has two parameter danger/success
       // $sales_date = Carbon::parse($this->mailVariables->salesDetails->sales_at)->format('d-M-Y');
        $oldProductTextWithPanel = $this->IncludePanelDesign($this->mailVariables->oldProductText, 'danger');
        $newProductTextWithPanel = $this->IncludePanelDesign($this->mailVariables->newProductText, 'success');
        $changesLog = $this->IncludePanelDesign($this->mailVariables->changeStringForEmail, 'warning');
        $amountText = $this->IncludePanelDesign($this->mailVariables->amountText);

        $mailMessage = (new MailMessage)
            ->greeting("Sales invoice ID# {$this->mailVariables->salesDetails->id} ({$this->mailVariables->customerName}) Edited Successfully")
            ->subject("Sales invoice ID# {$this->mailVariables->salesDetails->id} Edited ( {$this->mailVariables->customerName}) Successfully Please Approve again")
            ->line($this->mailVariables->mailText)
            ->line(new HtmlString('<h1>Changes</h1>'))
            ->line(new HtmlString($changesLog))
            ->line(new HtmlString('<h1>Current Sales Invoice Amount Details</h1>'))
            ->line(new HtmlString($amountText));
            if($this->mailVariables->oldSubTotal != $this->mailVariables->newSubTotal) {
                $mailMessage->line(new HtmlString('<h1>Old Product Details</h1>'))
                    ->line(new HtmlString($oldProductTextWithPanel))
                    ->line(new HtmlString('<h1>Current Product Details</h1>'))
                    ->line(new HtmlString($newProductTextWithPanel));
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
