<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReturnProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $returnproducts = array(
            array('id' => '1','user_id' => '308','discount' => '314.00','carrying_and_loading' => '0.00','amount' => '5962.00','returned_at' => '2022-04-24 17:16:31','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-24 23:16:31','updated_at' => '2022-04-24 23:16:31'),
            array('id' => '2','user_id' => '293','discount' => '64.00','carrying_and_loading' => '0.00','amount' => '1206.00','returned_at' => '2022-04-24 18:23:03','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-25 00:23:03','updated_at' => '2022-04-25 00:23:03'),
            array('id' => '3','user_id' => '293','discount' => '38.00','carrying_and_loading' => '0.00','amount' => '712.00','returned_at' => '2022-04-18 17:36:31','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-26 23:36:31','updated_at' => '2022-04-26 23:36:31'),
            array('id' => '4','user_id' => '291','discount' => '251.00','carrying_and_loading' => '0.00','amount' => '4759.00','returned_at' => '2022-04-23 17:37:33','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-26 23:37:33','updated_at' => '2022-04-26 23:37:33'),
            array('id' => '5','user_id' => '298','discount' => '60.00','carrying_and_loading' => '0.00','amount' => '1140.00','returned_at' => '2022-04-25 17:38:49','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-26 23:38:49','updated_at' => '2022-04-26 23:38:49'),
            array('id' => '6','user_id' => '289','discount' => '52.00','carrying_and_loading' => '0.00','amount' => '994.00','returned_at' => '2022-04-28 17:57:26','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-28 23:57:26','updated_at' => '2022-04-28 23:57:26'),
            array('id' => '7','user_id' => '293','discount' => '60.00','carrying_and_loading' => '0.00','amount' => '1140.00','returned_at' => '2022-04-28 17:58:00','type' => 'pos','returned_by' => 'indrajid sorker','return_status' => '0','approved_by' => NULL,'warehouse_id' => '2','deleted_at' => NULL,'created_at' => '2022-04-28 23:58:00','updated_at' => '2022-04-28 23:58:00')
        );

        /* `cp`.`product_returnproduct` */
        $product_returnproduct = array(
            array('id' => '1','product_id' => '5','returnproduct_id' => '1','user_id' => '308','qty' => '12','price' => '523','returned_at' => '2022-04-24 17:16:31','warehouse_id' => '2','created_at' => '2022-04-24 23:16:31','updated_at' => '2022-04-24 23:16:31'),
            array('id' => '2','product_id' => '7','returnproduct_id' => '2','user_id' => '293','qty' => '1','price' => '635','returned_at' => '2022-04-24 18:23:03','warehouse_id' => '2','created_at' => '2022-04-25 00:23:03','updated_at' => '2022-04-25 00:23:03'),
            array('id' => '3','product_id' => '6','returnproduct_id' => '2','user_id' => '293','qty' => '1','price' => '635','returned_at' => '2022-04-24 18:23:03','warehouse_id' => '2','created_at' => '2022-04-25 00:23:03','updated_at' => '2022-04-25 00:23:03'),
            array('id' => '4','product_id' => '33','returnproduct_id' => '3','user_id' => '293','qty' => '1','price' => '750','returned_at' => '2022-04-18 17:36:31','warehouse_id' => '2','created_at' => '2022-04-26 23:36:31','updated_at' => '2022-04-26 23:36:31'),
            array('id' => '5','product_id' => '14','returnproduct_id' => '4','user_id' => '291','qty' => '3','price' => '1670','returned_at' => '2022-04-23 17:37:33','warehouse_id' => '2','created_at' => '2022-04-26 23:37:33','updated_at' => '2022-04-26 23:37:33'),
            array('id' => '6','product_id' => '10','returnproduct_id' => '5','user_id' => '298','qty' => '1','price' => '1200','returned_at' => '2022-04-25 17:38:49','warehouse_id' => '2','created_at' => '2022-04-26 23:38:49','updated_at' => '2022-04-26 23:38:49'),
            array('id' => '7','product_id' => '4','returnproduct_id' => '6','user_id' => '289','qty' => '2','price' => '523','returned_at' => '2022-04-28 17:57:26','warehouse_id' => '2','created_at' => '2022-04-28 23:57:26','updated_at' => '2022-04-28 23:57:26'),
            array('id' => '8','product_id' => '10','returnproduct_id' => '7','user_id' => '293','qty' => '1','price' => '1200','returned_at' => '2022-04-28 17:58:00','warehouse_id' => '2','created_at' => '2022-04-28 23:58:00','updated_at' => '2022-04-28 23:58:00')
        );

        DB::table('returnproducts')->insert($returnproducts);
        DB::table('product_returnproduct')->insert($product_returnproduct);
    }
}
