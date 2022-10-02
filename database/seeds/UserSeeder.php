<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('id' => '282','name' => 'Md Shahidul','inventory_email' => NULL,'phone' => '01686565592','address' => 'Norshindi','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-09-26 14:32:49','updated_at' => '2021-10-25 17:41:03'),
            array('id' => '286','name' => 'Md Sazzad','inventory_email' => NULL,'phone' => '01752281201','address' => 'Dhanmondi','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-23 17:50:47','updated_at' => '2021-10-23 17:50:47'),
            array('id' => '287','name' => 'MS Sumi','inventory_email' => NULL,'phone' => '01909323237','address' => 'dhanmondi, modern','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-23 19:05:43','updated_at' => '2021-10-23 19:05:43'),
            array('id' => '288','name' => 'Md Rashed','inventory_email' => NULL,'phone' => '01994774693','address' => 'Munshigonj','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-23 19:12:10','updated_at' => '2021-10-25 17:38:16'),
            array('id' => '289','name' => 'Md Miraz','inventory_email' => NULL,'phone' => '01629141086','address' => 'Mirpur 10','company' => 'Crescent pharma','division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '1','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-23 19:39:55','updated_at' => '2021-10-23 19:39:55'),
            array('id' => '290','name' => 'Md Bayzid','inventory_email' => NULL,'phone' => '01936273579','address' => 'Kallanpur,kajipara','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:41:56','updated_at' => '2021-10-24 19:41:56'),
            array('id' => '291','name' => 'Md Delower','inventory_email' => NULL,'phone' => '01932113334','address' => 'Mirpur 1,Shisu Hospital.','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:44:35','updated_at' => '2021-10-24 19:44:35'),
            array('id' => '292','name' => 'Khusbu','inventory_email' => NULL,'phone' => '01754112957','address' => 'Kachukhet','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:47:18','updated_at' => '2021-10-24 19:47:18'),
            array('id' => '293','name' => 'Md Noman','inventory_email' => NULL,'phone' => '01884799957','address' => 'Shorawardi Medical','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '1','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:49:10','updated_at' => '2021-11-16 12:14:42'),
            array('id' => '294','name' => 'Md Musa','inventory_email' => NULL,'phone' => '01790060999','address' => 'Savar','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:52:15','updated_at' => '2021-10-24 19:52:15'),
            array('id' => '295','name' => 'Md khairul','inventory_email' => NULL,'phone' => '01748667645','address' => 'Gazipur','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:55:05','updated_at' => '2021-10-24 19:55:05'),
            array('id' => '296','name' => 'Md Ismail','inventory_email' => NULL,'phone' => '01983030052','address' => 'Uttara','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-24 19:56:59','updated_at' => '2021-10-24 19:56:59'),
            array('id' => '297','name' => 'Md shirajul Islam','inventory_email' => NULL,'phone' => '01837864614','address' => 'Uttara','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 16:49:15','updated_at' => '2021-10-25 16:49:15'),
            array('id' => '298','name' => 'Md Kamrul Islam','inventory_email' => NULL,'phone' => '01742956834','address' => 'Dhanmondi7','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 16:53:06','updated_at' => '2021-10-25 16:53:06'),
            array('id' => '299','name' => 'Sumi','inventory_email' => NULL,'phone' => '01909323237','address' => 'Dhanmodi 6','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 16:54:56','updated_at' => '2021-10-25 16:54:56'),
            array('id' => '300','name' => 'Md Repon','inventory_email' => NULL,'phone' => '01626324173','address' => 'Panthopath','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 16:56:43','updated_at' => '2021-10-25 16:56:43'),
            array('id' => '301','name' => 'Md Raton','inventory_email' => NULL,'phone' => '01714566906','address' => 'Dhanmodi labaid','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 16:58:17','updated_at' => '2021-10-25 16:58:17'),
            array('id' => '302','name' => 'Md Siam rubel','inventory_email' => NULL,'phone' => '01848368707','address' => 'Kakrail','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:00:19','updated_at' => '2021-10-25 17:00:19'),
            array('id' => '303','name' => 'Md Hosain','inventory_email' => NULL,'phone' => '01751782224','address' => 'Badda','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:02:44','updated_at' => '2021-10-25 17:02:44'),
            array('id' => '304','name' => 'Md Delower','inventory_email' => NULL,'phone' => '01642414493','address' => 'Bhulta','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:06:01','updated_at' => '2021-10-25 17:06:01'),
            array('id' => '305','name' => 'Md Nahid','inventory_email' => NULL,'phone' => '01601415847','address' => 'N gonj','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:07:32','updated_at' => '2021-10-25 17:07:32'),
            array('id' => '306','name' => 'Md Shohel','inventory_email' => NULL,'phone' => '01938237221','address' => 'Jatrabar','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:09:13','updated_at' => '2021-10-25 17:09:13'),
            array('id' => '307','name' => 'Md Ruhol amin','inventory_email' => NULL,'phone' => '01943923212','address' => 'Comillah','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:10:39','updated_at' => '2021-10-25 17:10:39'),
            array('id' => '308','name' => 'Md Tuhin','inventory_email' => NULL,'phone' => '01755282231','address' => 'Rangpur','company' => NULL,'division_id' => '7','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:12:04','updated_at' => '2021-10-25 17:12:04'),
            array('id' => '309','name' => 'Md Ariful','inventory_email' => NULL,'phone' => '01749538037','address' => 'Konabari Gazipor','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '1','sub_customer' => '1','sub_customer_json' => NULL,'sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-25 17:43:41','updated_at' => '2021-10-25 17:43:41'),
            array('id' => '311','name' => 'B baria mahmud','inventory_email' => NULL,'phone' => '01736566376','address' => 'dhaka','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '0','login_access' => '1','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-30 18:06:36','updated_at' => '2021-11-25 18:41:50'),
            array('id' => '312','name' => 'Alauddin','inventory_email' => NULL,'phone' => '01648912488','address' => 'Dhaka','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '0','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-10-30 18:29:22','updated_at' => '2021-10-30 18:29:22'),
            array('id' => '313','name' => 'Md Noman sonargon','inventory_email' => NULL,'phone' => '01815697728','address' => 'Sonargoan','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-10 20:08:59','updated_at' => '2021-11-10 20:08:59'),
            array('id' => '314','name' => 'Md shakil','inventory_email' => NULL,'phone' => '01632375065','address' => 'Pg','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '1','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-15 17:58:26','updated_at' => '2021-11-15 17:59:09'),
            array('id' => '315','name' => 'Kazi pharmacy','inventory_email' => NULL,'phone' => '01754481644','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => '"[{\\"o_name\\":\\"Cap. Bilotrust\\",\\"name\\":\\"Cap.Bilotrust\\",\\"price\\":\\"650\\",\\"id\\":\\"22\\"},{\\"o_name\\":\\"Ketocite Cream\\",\\"name\\":\\"KetociteCream\\",\\"price\\":\\"580\\",\\"id\\":\\"27\\"}]"','section_id' => '2','sub_customer' => '0','sub_customer_json' => '','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-16 12:38:37','updated_at' => '2021-11-16 12:40:25'),
            array('id' => '316','name' => 'Care pharmacy','inventory_email' => NULL,'phone' => '01861677755','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-16 12:47:20','updated_at' => '2021-11-16 12:47:20'),
            array('id' => '317','name' => 'Al Modina pharmacy','inventory_email' => NULL,'phone' => '01709364788','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:21:26','updated_at' => '2021-11-18 12:21:26'),
            array('id' => '318','name' => 'Thakurgaon pharmacy (Model)','inventory_email' => NULL,'phone' => '01749512468','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:23:01','updated_at' => '2021-11-18 12:23:01'),
            array('id' => '319','name' => 'Billa pharmacy','inventory_email' => NULL,'phone' => '01819162388','address' => 'Collage gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:24:11','updated_at' => '2021-11-18 12:24:11'),
            array('id' => '320','name' => 'Thakurgaon pharmacy 2','inventory_email' => NULL,'phone' => '01749512468','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:28:19','updated_at' => '2021-11-18 12:28:19'),
            array('id' => '321','name' => 'Medi best pharmacy','inventory_email' => NULL,'phone' => '01711064131','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:29:46','updated_at' => '2021-11-18 12:29:46'),
            array('id' => '322','name' => 'Tonima pharmacy','inventory_email' => NULL,'phone' => '01759222613','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:30:46','updated_at' => '2021-11-18 12:30:46'),
            array('id' => '323','name' => 'Rohoman pharmacy','inventory_email' => NULL,'phone' => '01749860037','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:33:13','updated_at' => '2021-11-18 12:33:13'),
            array('id' => '324','name' => 'Bushra pharmacy','inventory_email' => NULL,'phone' => '01716053625','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:35:33','updated_at' => '2021-11-18 12:35:33'),
            array('id' => '325','name' => 'Ismi pharmacy','inventory_email' => NULL,'phone' => '01736672001','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:38:02','updated_at' => '2021-11-18 12:38:02'),
            array('id' => '326','name' => 'Al sami pharmacy','inventory_email' => NULL,'phone' => '01701644503','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:39:19','updated_at' => '2021-11-18 12:39:19'),
            array('id' => '327','name' => 'Josim pharmacy','inventory_email' => NULL,'phone' => '01830890092','address' => 'Collage gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:41:34','updated_at' => '2021-11-18 12:41:34'),
            array('id' => '328','name' => 'Green Life pharmacy','inventory_email' => NULL,'phone' => '01723679414','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:43:12','updated_at' => '2021-11-18 12:43:12'),
            array('id' => '329','name' => 'Rogmukti pharmacy','inventory_email' => NULL,'phone' => '01959594707','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:47:08','updated_at' => '2021-11-18 12:47:08'),
            array('id' => '330','name' => 'Onurag pharmacy','inventory_email' => NULL,'phone' => '01728747004','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 12:49:49','updated_at' => '2021-11-18 12:49:49'),
            array('id' => '331','name' => 'Bangladesh pharmacy','inventory_email' => NULL,'phone' => '01940649105','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => '','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:00:53','updated_at' => '2021-11-18 13:04:31'),
            array('id' => '332','name' => 'Niramoy pharmacy 2','inventory_email' => NULL,'phone' => '01954545699','address' => 'Collage gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:06:54','updated_at' => '2021-11-18 13:06:54'),
            array('id' => '333','name' => 'Niramay pharmacy','inventory_email' => NULL,'phone' => '01954545699','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:07:46','updated_at' => '2021-11-18 13:07:46'),
            array('id' => '334','name' => 'Nazz pharmacy','inventory_email' => NULL,'phone' => '01758274867','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:08:53','updated_at' => '2021-11-18 13:08:53'),
            array('id' => '335','name' => 'Jaki pharmacy','inventory_email' => NULL,'phone' => '01849664824','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:22:34','updated_at' => '2021-11-18 13:22:34'),
            array('id' => '336','name' => 'Dhaka Central pharmacy','inventory_email' => NULL,'phone' => '01639769004','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:24:22','updated_at' => '2021-11-18 13:24:22'),
            array('id' => '337','name' => 'Lazz Pharma  (Shyamoli)','inventory_email' => NULL,'phone' => '01831558843','address' => 'College gate','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => '','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 13:25:47','updated_at' => '2021-11-18 13:27:21'),
            array('id' => '338','name' => 'Leed pharma','inventory_email' => NULL,'phone' => '01797033061','address' => 'Tajmohol Road','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 16:43:19','updated_at' => '2021-11-18 16:43:19'),
            array('id' => '339','name' => 'Lazz Pharma (Mohammadpur)','inventory_email' => NULL,'phone' => '01707006577','address' => 'Mohammad pur','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 16:46:06','updated_at' => '2021-11-18 16:46:06'),
            array('id' => '340','name' => 'Johura pharmacy','inventory_email' => NULL,'phone' => '01745142509','address' => 'Town Hall','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '0','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-18 16:51:57','updated_at' => '2021-11-18 16:51:57'),
            array('id' => '341','name' => 'Md.mahmud rahman','inventory_email' => NULL,'phone' => '01973358342','address' => 'elephant road','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '0','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2021-11-30 18:45:00','updated_at' => '2021-11-30 18:45:00'),
            array('id' => '342','name' => 'yeasin','inventory_email' => NULL,'phone' => '01886889427','address' => 'rampura','company' => 'crescentpharma','division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-03-25 03:30:20','updated_at' => '2022-03-25 03:30:20'),
            array('id' => '343','name' => 'Md sujon','inventory_email' => NULL,'phone' => '01705160481','address' => 'mohakhali','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-03-25 03:32:38','updated_at' => '2022-03-25 03:32:38'),
            array('id' => '344','name' => 'Md Rasel','inventory_email' => NULL,'phone' => '01779652820','address' => 'konabari','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-03-25 03:33:52','updated_at' => '2022-03-25 03:33:52'),
            array('id' => '345','name' => 'Md Ashraful','inventory_email' => NULL,'phone' => '01945251780','address' => 'Shorawardy medical college','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:02:35','updated_at' => '2022-04-17 09:02:35'),
            array('id' => '346','name' => 'Md Imran','inventory_email' => NULL,'phone' => '01633582393','address' => 'Shorawardy medical','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:04:16','updated_at' => '2022-04-17 09:04:16'),
            array('id' => '347','name' => 'Md shakil','inventory_email' => NULL,'phone' => '01316905980','address' => 'Savar baypel','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:07:30','updated_at' => '2022-04-17 09:07:30'),
            array('id' => '348','name' => 'Md raju','inventory_email' => NULL,'phone' => '01755092936','address' => 'Savar','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:11:04','updated_at' => '2022-04-17 09:11:04'),
            array('id' => '349','name' => 'Md kader','inventory_email' => NULL,'phone' => '01892360606','address' => 'Dinaj por','company' => NULL,'division_id' => '7','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:13:18','updated_at' => '2022-04-17 09:13:18'),
            array('id' => '350','name' => 'Md Antor','inventory_email' => NULL,'phone' => '01971884038','address' => 'Jatrabari','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:17:43','updated_at' => '2022-04-17 09:17:43'),
            array('id' => '351','name' => 'Shanta','inventory_email' => NULL,'phone' => '01781161482','address' => 'Pg','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-17 09:20:20','updated_at' => '2022-04-17 09:20:20'),
            array('id' => '352','name' => 'Ms Makhsuda','inventory_email' => NULL,'phone' => '01786895899','address' => 'Mitford','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-18 20:33:02','updated_at' => '2022-04-18 20:33:02'),
            array('id' => '353','name' => 'Md jobayer alom','inventory_email' => NULL,'phone' => '01308459342','address' => 'Mymensingh','company' => NULL,'division_id' => '8','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-18 21:34:51','updated_at' => '2022-04-18 21:34:51'),
            array('id' => '354','name' => 'Md. Masud','inventory_email' => NULL,'phone' => '01910227981','address' => 'Labaid','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-20 00:05:01','updated_at' => '2022-04-20 00:05:01'),
            array('id' => '355','name' => 'Md.Robiul Islam','inventory_email' => NULL,'phone' => '01710077945','address' => 'Norsinghdi','company' => NULL,'division_id' => '6','email_verified_at' => NULL,'password' => NULL,'user_type' => 'pos','image' => 'user.jpg','status' => '0','pricedata' => NULL,'section_id' => '2','sub_customer' => '1','sub_customer_json' => 'null','sms_alert' => '1','login_access' => '0','deleted_at' => NULL,'remember_token' => NULL,'created_at' => '2022-04-21 01:42:44','updated_at' => '2022-04-21 01:42:44')
        );
        DB::table('users')->insert($users);

    }
}
