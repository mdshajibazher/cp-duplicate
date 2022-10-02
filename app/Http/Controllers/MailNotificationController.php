<?php

namespace App\Http\Controllers;

use App\MailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class MailNotificationController extends Controller
{
    public function dispatchNotificationMail()
    {
        $pendingMailNotification = MailLog::where('status',false)->get();
        if(count($pendingMailNotification) > 0) {
            foreach ($pendingMailNotification as $pendingMail) {
                $mailLog = json_decode($pendingMail);
                $mailVariables = json_decode($mailLog->mail_variables);
                $mailTo =   $mailVariables->notificationTo->model::whereIn('id', $mailVariables->notificationTo->ids)->get();
                $notificationClassString = $mailLog->mail_notifications_class;
                $instanceOfNotificationClass = new $notificationClassString($mailVariables);
                Notification::sendNow($mailTo, $instanceOfNotificationClass);
                MailLog::where('id', $pendingMail->id)
                    ->update(['status' => true]);
            }
            return response()->json(["message" => "Mail Sent Successfully"]);
        }else{
            return response()->json(["message" => "No Emails are pending"]);
        }
    }

}
