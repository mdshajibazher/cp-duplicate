<?php

use Illuminate\Database\Seeder;

class PaymentmethodsTableSeeder extends Seeder
{


    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('paymentmethods')->delete();

        \DB::table('paymentmethods')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Hand Cash',
                'image' => 'hand-cash-2020-06-14.png',
                'ac_number' => NULL,
                'description' => 'You can Pay The Amount When the product will be delivered',
                'deleted_at' => NULL,
                'created_at' => '2020-06-14 00:08:46',
                'updated_at' => '2020-10-31 07:16:51',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Bank',
                'image' => 'bank-2020-09-02.png',
                'ac_number' => NULL,
                'description' => '.',
                'deleted_at' => NULL,
                'created_at' => '2020-09-02 15:41:32',
                'updated_at' => '2020-09-02 15:41:32',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Cash On Delivery',
                'image' => 'cash-on-delivery-2020-10-31.png',
                'ac_number' => NULL,
                'description' => 'You can pay the amount When the product is handed over you',
                'deleted_at' => NULL,
                'created_at' => '2020-10-31 07:18:13',
                'updated_at' => '2020-10-31 07:18:13',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'bKash',
                'image' => 'bkash-2021-10-09.png',
                'ac_number' => '01891970962',
                'description' => '.',
                'deleted_at' => NULL,
                'created_at' => '2021-10-09 13:38:05',
                'updated_at' => '2021-10-09 13:38:05',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Nagad',
                'image' => 'nagad-2021-10-09.png',
                'ac_number' => '01736402322',
                'description' => '.',
                'deleted_at' => NULL,
                'created_at' => '2021-10-09 13:39:20',
                'updated_at' => '2021-10-09 13:39:20',
            ),
        ));


    }
}
