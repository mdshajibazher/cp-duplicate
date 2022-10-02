<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $general_options = array(
            array('id' => '1','options' => '{"inv_diff_invoice_heading":0,"inv_invoice_heading":"Crescent Pharma","auto_signature_inv":"1","inv_invoice_email":"crescentpharma@gmail.com","inv_invoice_address":"Tropical Center, 10th floor,Bata signal Elephant Road Dhaka","inv_invoice_logo":"1634694086-2021-10-20.jpg","inv_invoice_phone":"01973358342","warehouse_id":"2","cust_sales_invoice_includes_product":0,"cust_return_invoice_includes_product":0,"max_product_character_allowed":"360","sms_delay_in_days":"4","admin_sales_invoice_created_notify":"1","admin_list_sales_invoice_created_notify":["2"],"admin_sales_invoice_edited_notify":"1","admin_list_sales_invoice_edited_notify":["2"],"admin_sales_invoice_canceled_notify":"1","admin_list_sales_invoice_canceled_notify":["2"],"admin_return_invoice_created_notify":"1","admin_list_return_invoice_created_notify":["2"],"admin_return_invoice_edited_notify":"1","admin_list_return_invoice_edited_notify":["2"],"admin_return_invoice_canceled_notify":"1","admin_list_return_invoice_canceled_notify":["2"],"admin_cash_edited_notify":"1","customer_sales_invoice_created_notify":0,"customer_sales_invoice_edited_notify":0,"customer_sales_invoice_delivered_notify":0,"customer_sales_invoice_canceled_notify":0,"customer_return_invoice_created_notify":0,"customer_return_invoice_edited_notify":0,"customer_return_invoice_canceled_notify":0,"customer_cash_approval_notify":0,"d_agent_sales_invoice_created_notify":"1","d_agent_sales_invoice_edited_notify":"1","d_agent_sales_invoice_includes_product":"1","d_agent_list_sales_invoice_notify":["5"],"admin_email_sales_invoice_created":0,"admin_list_email_sales_invoice_created":["2"],"admin_email_sales_invoice_edited":0,"admin_list_email_sales_invoice_edited":["2"],"admin_email_return_invoice_created":0,"admin_list_email_return_invoice_created":["2"],"admin_email_return_invoice_edited":0,"admin_list_email_return_invoice_edited":["2"],"admin_daily_order_created_notify":"1","admin_list_daily_order_created_notify":["2"],"admin_daily_order_edited_notify":"1","admin_list_daily_order_edited_notify":["2"]}','created_at' => NULL,'updated_at' => '2022-04-17 02:21:47')
        );
        DB::table('general_options')->insert($general_options);
    }
}
