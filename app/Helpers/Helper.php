<?php

use App\Order;
use App\Smsconfig;
use App\Returnproduct;
use Illuminate\Support\Facades\DB;

function runBackupCommand(){
    $todays_date = \Carbon\Carbon::now()->toDateString();
    $backupLogInitialQuery = \App\BackupLog::query();
    if(isWeekend($todays_date)){
        $backupExist = $backupLogInitialQuery->where('date' , $todays_date)->first();
        if(!$backupExist){
            $call = \Illuminate\Support\Facades\Artisan::call('backup:run --only-db');
            \App\BackupLog::create(['date' => $todays_date]);
        }
    }
}

function getMonthName($month_id){
    $month = "";
    switch ($month_id) {
        case 1:
            $month = 'Jan';
            break;
        case 2:
            $month = 'Feb';
            break;

        case 3:
            $month = 'Mar';
            break;
        case 4:
            $month = 'Apr';
            break;
        case 5:
            $month = 'May';
            break;
        case 6:
            $month = 'Jun';
            break;
        case 7:
            $month = 'Jul';
            break;
        case 8:
            $month = 'Aug';
            break;
        case 9:
            $month = 'Sep';
            break;
        case 10:
            $month = 'Oct';
            break;
        case 11:
            $month = 'Nov';
            break;
        case 12:
            $month = 'Dec';
            break;
        default:
            $month = 'Not a valid month!';

            break;
        }

        return $month;
}
function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}
function mailNotificationLogger($mail_variable,$mail_notification_class){
    $mailLog = new \App\MailLog;
    $mailLog->mail_variables = json_encode($mail_variable);
    $mailLog->mail_notifications_class = $mail_notification_class;
    $mailLog->status = false;
    $mailLog->save();
    return $mailLog;

}
function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}



function getSectionTitle($section_id=null){
    if($section_id == null || $section_id === "all"){
        return "Crescent Pharma";
    }
    $section_name = App\Section::find($section_id)->name;
    $company_title = "";
    if($section_name === 'Wholesale'){
        $company_title = "Crescent Trade International";
    }elseif($section_name === 'Cosmetics'){
        $company_title = "Crescent Pharma";
    }
    return $company_title;
}

function getCustomersSectionTitle($user_id){
    $company_title = "";
    $user = App\User::with('section')->findOrFail($user_id);
    $section_name =  $user->section->name;
    if($section_name === 'Wholesale'){
        $company_title = "Vision Trade International";
    }elseif($section_name === 'Cosmetics'){
        $company_title = "Vision Cosmetics Ltd";
    }
    return $company_title;
}

function logSMSInDB($text="", $numbers_csv_string="", $status_code ="" ){
    $smsLog = new \App\SmsLog;
    $smsLog->text = $text;
    $smsLog->phones = $numbers_csv_string;
    $smsLog->status_code = $status_code;
    $smsLog->admin_id = Auth::user()->id;
    $smsLog->save();
    return $smsLog;
}

function sendSMS($text="", $numbers_csv_string){
    $url =  config('custom_variable.sms_configuration.sms_api_url');
    $data= array(
    'username'=> config('custom_variable.sms_configuration.sms_api_username'),
    'password'=> config('custom_variable.sms_configuration.sms_api_secret'),
    'number'=>"$numbers_csv_string",
    'message'=>"$text"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    $p = explode("|",$smsresult);
    $sendstatus = $p[0] ?? 1444;
    return  $sendstatus;
}



 function SplitName($name){
$splitName = explode(' ', $name);
$modifiedName = $splitName[0]." ".$splitName[1];
return $modifiedName;

}

function FashiOrderStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">approved</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">cancelled</span>';
    }
    return $status;
}

function FashiSalesStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">approved</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">cancelled</span>';
    }
    return $status;
}
function FashiPaymentStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">paid</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">cancelled</span>';
    }
    return $status;
}

function AdminLoginStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-danger">disabled</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">active</span>';
    }
    return $status;
}
function FashiShippingStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">Delivered</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">cancelled</span>';
    }
    return $status;
}
function InvCashStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">Approved</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">Cancelled</span>';
    }
    return $status;
}

function delivereyMode($arg){
    if($arg === 'courier'){
        return '<span class="badge badge-danger"> via courier/transport</span>';
    }elseif($arg === 'office'){
        return '<span class="badge badge-warning">office delivery</span>';
    }else{
        return '<span class="badge badge-info">undefined</span>';
    }
}
function fuc_is_conditioned($arg){
    if($arg == 1){
        return '<span class="badge badge-success">conditioned</span>';
    }elseif($arg == 0){
        return '<span class="badge badge-danger">normal</span>';
    }else{
        return "";
    }
}

function CustomerSection($arg){
    if($arg === 'Cosmetics'){
        return '<span class="badge badge-danger">'.$arg.'</span>';
    }elseif($arg === 'Wholesale'){
        return '<span class="badge badge-warning">'.$arg.'</span>';
    }elseif($arg === 'Self'){
        return '<span class="badge badge-danger">'.$arg.'</span>';
    }else{
        return '<span class="badge badge-dark">'.$arg.'</span>';
    }
}
function VisionSmsResponse($response){
    if($response == 1101){
        return "success";
    }elseif($response == 1000){
        return "Invalid user or Password";
    }elseif($response == 1002){
        return "Empty Number";
    }elseif($response == 1003){
        return "Invalid message or empty message";
    }elseif($response == 1004 ){
        return "Invalid number";
    }elseif($response == 1005 ){
        return "All Number is Invalid";
    }elseif($response == 1006  ){
        return "insufficient Balance";
    }elseif($response == 1009 ){
        return "Inactive Account";
    }elseif($response == 1010 ){
        return "Max number limit exceeded";
    }elseif($response == 1011 ){
        return "Date Range Exceeded to Sendig SMS";
    } elseif($response == 1444 ){
        return "No response from server";
    }elseif($response == 1445 ){
        return "SMS currently disabled";
    }
    else{
        return "No Sms Sent";
    }
}

function showProductTypes($argument){
    $status = "";
    if($argument == 'ecom' ){
        $status = '<span class="badge badge-warning">E-commerce</span>';
    }elseif($argument == 'pos'){
        $status = '<span class="badge badge-danger">Inventory</span>';
    }elseif($argument == 'raw'){
        $status = '<span class="badge badge-danger">Raw Materials</span>';
    }
    return $status;
}

function InvReturnStatus($argument){
    $status = "";
    if($argument == 0 ){
        $status = '<span class="badge badge-warning">pending</span>';
    }elseif($argument == 1){
        $status = '<span class="badge badge-success">Approved</span>';
    }elseif($argument == 2){
        $status = '<span class="badge badge-danger">Cancelled</span>';
    }
    return $status;
}

function FashiGetAmount($order_id){
    $order = Order::with('product')->findOrFail($order_id);

    $items = [];
    foreach($order->product as $single_product){
        $items[] = $single_product->pivot->price*$single_product->pivot->qty;
    }
    $subtotal = array_sum($items);

    $discount_amount = $subtotal*($order->discount/100);
    $taxableAmount = $subtotal-$discount_amount;
    $shipping_cahrges  = $order->shipping;
    $vat_amount = $taxableAmount*($order->vat/100);
    $tax_amount = $taxableAmount*($order->tax/100);
    $grand_total = ($taxableAmount+$vat_amount+$tax_amount+$shipping_cahrges)-($order->cash);

    return $grand_total;
}

function FashiGetSalesAmount($order_id){
    $order = Order::with('product')->findOrFail($order_id);

    $items = [];
    foreach($order->product as $single_product){
        $items[] = $single_product->pivot->price*$single_product->pivot->qty;
    }
    $subtotal = array_sum($items);

    $discount_amount = $subtotal*($order->discount/100);
    $taxableAmount = $subtotal-$discount_amount;
    $shipping_cahrges  = $order->shipping;
    $vat_amount = $taxableAmount*($order->vat/100);
    $tax_amount = $taxableAmount*($order->tax/100);
    $grand_total = ($taxableAmount+$vat_amount+$tax_amount+$shipping_cahrges);

    return $grand_total;
}






function FashiGetReturnAmount($return_id){
    $returns = Returnproduct::with('product')->findOrFail($return_id);

    $items = [];
    foreach($returns->product as $single_product){
        $items[] = $single_product->pivot->price*$single_product->pivot->qty;
    }
    $subtotal = array_sum($items);

    $discount_amount = $subtotal*($returns->discount_percent/100);
    $carrying_and_loading = $returns->carrying_and_loading;
    $grand_total = ( $subtotal+$carrying_and_loading) -($discount_amount);

    return $grand_total;
}



?>
