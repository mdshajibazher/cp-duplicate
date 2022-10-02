<?php

use Illuminate\Database\Seeder;

class AdjustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adjusts = array(
            array('id' => '1','type' => 'increase','product_id' => '29','qty' => '316','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:01:24','updated_at' => '2022-04-17 03:04:29'),
            array('id' => '2','type' => 'increase','product_id' => '21','qty' => '668','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:01:45','updated_at' => '2022-04-17 03:05:04'),
            array('id' => '3','type' => 'increase','product_id' => '6','qty' => '177','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:02:09','updated_at' => '2022-04-17 03:05:21'),
            array('id' => '4','type' => 'increase','product_id' => '5','qty' => '16','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:03:32','updated_at' => '2022-04-17 03:05:39'),
            array('id' => '5','type' => 'increase','product_id' => '4','qty' => '302','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:06:10','updated_at' => '2022-04-17 03:06:10'),
            array('id' => '6','type' => 'increase','product_id' => '13','qty' => '1','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:06:26','updated_at' => '2022-04-17 03:06:26'),
            array('id' => '7','type' => 'increase','product_id' => '22','qty' => '193','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:06:44','updated_at' => '2022-04-17 03:06:44'),
            array('id' => '8','type' => 'increase','product_id' => '23','qty' => '67','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:07:25','updated_at' => '2022-04-17 03:07:25'),
            array('id' => '9','type' => 'increase','product_id' => '18','qty' => '49','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:08:10','updated_at' => '2022-04-17 03:08:10'),
            array('id' => '10','type' => 'increase','product_id' => '25','qty' => '427','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:08:25','updated_at' => '2022-04-17 03:08:25'),
            array('id' => '11','type' => 'increase','product_id' => '32','qty' => '419','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:08:48','updated_at' => '2022-04-17 03:08:48'),
            array('id' => '12','type' => 'increase','product_id' => '27','qty' => '130','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:09:16','updated_at' => '2022-04-17 03:09:16'),
            array('id' => '13','type' => 'increase','product_id' => '11','qty' => '9','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:09:32','updated_at' => '2022-04-17 03:09:57'),
            array('id' => '14','type' => 'increase','product_id' => '7','qty' => '45','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:10:25','updated_at' => '2022-04-17 03:10:25'),
            array('id' => '15','type' => 'increase','product_id' => '9','qty' => '628','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:10:46','updated_at' => '2022-04-17 03:10:46'),
            array('id' => '16','type' => 'increase','product_id' => '20','qty' => '491','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:11:05','updated_at' => '2022-04-17 03:11:05'),
            array('id' => '17','type' => 'increase','product_id' => '31','qty' => '67','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:11:21','updated_at' => '2022-04-17 03:11:21'),
            array('id' => '18','type' => 'increase','product_id' => '30','qty' => '228','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:11:46','updated_at' => '2022-04-17 03:11:46'),
            array('id' => '19','type' => 'increase','product_id' => '14','qty' => '28','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:12:28','updated_at' => '2022-04-17 03:12:28'),
            array('id' => '20','type' => 'increase','product_id' => '15','qty' => '86','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:13:05','updated_at' => '2022-04-17 03:13:05'),
            array('id' => '21','type' => 'increase','product_id' => '16','qty' => '51','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:13:32','updated_at' => '2022-04-17 03:13:32'),
            array('id' => '22','type' => 'increase','product_id' => '26','qty' => '3','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:13:49','updated_at' => '2022-04-17 03:13:49'),
            array('id' => '23','type' => 'increase','product_id' => '10','qty' => '362','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 03:14:11','updated_at' => '2022-04-17 03:14:11'),
            array('id' => '24','type' => 'increase','product_id' => '33','qty' => '212','adjusted_at' => '2022-04-14 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-17 19:44:08','updated_at' => '2022-04-17 19:44:08'),
            array('id' => '25','type' => 'increase','product_id' => '5','qty' => '126','adjusted_at' => '2022-04-18 00:00:00','notes' => '12','warehouse_id' => '2','created_at' => '2022-04-18 17:39:42','updated_at' => '2022-04-18 17:39:42'),
            array('id' => '26','type' => 'increase','product_id' => '14','qty' => '176','adjusted_at' => '2022-04-18 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-18 23:53:35','updated_at' => '2022-04-18 23:53:35'),
            array('id' => '27','type' => 'increase','product_id' => '15','qty' => '176','adjusted_at' => '2022-04-18 00:00:00','notes' => '176','warehouse_id' => '2','created_at' => '2022-04-18 23:56:12','updated_at' => '2022-04-18 23:56:12'),
            array('id' => '28','type' => 'increase','product_id' => '33','qty' => '240','adjusted_at' => '2022-04-21 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-22 01:31:40','updated_at' => '2022-04-22 01:31:40'),
            array('id' => '29','type' => 'increase','product_id' => '4','qty' => '1008','adjusted_at' => '2022-04-21 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-22 01:32:11','updated_at' => '2022-04-22 01:32:11'),
            array('id' => '30','type' => 'increase','product_id' => '6','qty' => '240','adjusted_at' => '2022-04-21 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-22 01:32:37','updated_at' => '2022-04-22 01:32:37'),
            array('id' => '31','type' => 'increase','product_id' => '9','qty' => '288','adjusted_at' => '2022-04-21 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-22 01:33:10','updated_at' => '2022-04-22 01:33:10'),
            array('id' => '32','type' => 'increase','product_id' => '20','qty' => '200','adjusted_at' => '2022-04-21 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-22 01:33:29','updated_at' => '2022-04-22 01:33:29'),
            array('id' => '33','type' => 'increase','product_id' => '5','qty' => '101','adjusted_at' => '2022-04-23 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-23 17:23:35','updated_at' => '2022-04-23 17:23:35'),
            array('id' => '34','type' => 'increase','product_id' => '5','qty' => '100','adjusted_at' => '2022-04-24 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-25 01:32:34','updated_at' => '2022-04-25 01:32:34'),
            array('id' => '35','type' => 'increase','product_id' => '5','qty' => '100','adjusted_at' => '2022-04-27 00:00:00','notes' => NULL,'warehouse_id' => '2','created_at' => '2022-04-27 19:09:51','updated_at' => '2022-04-27 19:09:51')
        );
        DB::table('adjusts')->insert($adjusts);
    }
}
