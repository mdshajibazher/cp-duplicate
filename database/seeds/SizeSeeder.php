<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = array(
            array('id' => '1','name' => '100 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-12 16:01:36','updated_at' => '2020-06-12 16:01:36'),
            array('id' => '2','name' => '200 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-12 16:10:50','updated_at' => '2020-06-12 16:10:50'),
            array('id' => '3','name' => '15 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-13 15:48:31','updated_at' => '2020-06-13 15:48:31'),
            array('id' => '4','name' => '75 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-13 16:01:35','updated_at' => '2020-06-13 16:01:35'),
            array('id' => '5','name' => '250 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-13 16:08:03','updated_at' => '2020-06-13 16:08:03'),
            array('id' => '6','name' => '14 gm','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-06-16 18:11:00','updated_at' => '2020-06-16 18:11:00'),
            array('id' => '8','name' => '50 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-17 02:25:43','updated_at' => '2020-06-17 02:25:43'),
            array('id' => '9','name' => '30 gm','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-06-27 04:42:58','updated_at' => '2020-06-27 04:42:58'),
            array('id' => '10','name' => '500 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-06-27 04:43:58','updated_at' => '2020-06-27 04:43:58'),
            array('id' => '11','name' => '25 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-07-03 11:29:56','updated_at' => '2020-11-27 00:27:56'),
            array('id' => '12','name' => 'not defined','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-07-04 08:07:42','updated_at' => '2020-07-04 08:27:58'),
            array('id' => '13','name' => '50 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-07-17 09:54:12','updated_at' => '2020-07-17 09:54:12'),
            array('id' => '16','name' => '180 ml','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-08-13 20:24:40','updated_at' => '2020-08-13 20:24:40'),
            array('id' => '17','name' => '60 ml','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-08-17 17:03:58','updated_at' => '2020-08-17 17:03:58'),
            array('id' => '18','name' => '100 gm','type' => 'pos','deleted_at' => NULL,'created_at' => '2020-08-17 17:07:49','updated_at' => '2020-08-17 17:07:49'),
            array('id' => '20','name' => '90 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-08-19 19:01:51','updated_at' => '2020-08-19 19:01:51'),
            array('id' => '21','name' => '120 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-10-05 16:34:33','updated_at' => '2020-10-05 16:34:33'),
            array('id' => '22','name' => '6 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-10-08 13:54:37','updated_at' => '2020-10-08 13:54:37'),
            array('id' => '23','name' => '200 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-10-15 12:09:54','updated_at' => '2020-10-15 12:11:51'),
            array('id' => '24','name' => '60 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-10-21 16:12:23','updated_at' => '2020-10-21 16:12:23'),
            array('id' => '25','name' => '9 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-11-01 18:05:07','updated_at' => '2020-11-01 18:05:07'),
            array('id' => '26','name' => '150 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-11-07 11:52:56','updated_at' => '2020-11-07 11:52:56'),
            array('id' => '27','name' => '20 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-11-07 13:39:57','updated_at' => '2020-11-07 13:39:57'),
            array('id' => '28','name' => 'Small','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-11-29 07:47:08','updated_at' => '2020-11-29 07:47:08'),
            array('id' => '30','name' => '30 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2020-12-21 16:50:43','updated_at' => '2020-12-21 16:50:43'),
            array('id' => '31','name' => '105 ml','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-01-03 17:36:49','updated_at' => '2021-01-03 17:36:49'),
            array('id' => '32','name' => '10 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-02-03 14:48:09','updated_at' => '2021-02-03 14:48:09'),
            array('id' => '33','name' => '1000 gm','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-02-15 11:36:17','updated_at' => '2021-02-15 11:36:17'),
            array('id' => '34','name' => '20 mg','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-10-23 17:26:10','updated_at' => '2021-10-23 17:26:10'),
            array('id' => '35','name' => '30 mg','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-10-23 17:27:05','updated_at' => '2021-10-23 17:27:05'),
            array('id' => '36','name' => '30\'s','type' => 'ecom','deleted_at' => NULL,'created_at' => '2021-10-23 17:29:13','updated_at' => '2021-10-23 17:29:13')
        );
    DB::table('sizes')->insert($sizes);
    }
}
