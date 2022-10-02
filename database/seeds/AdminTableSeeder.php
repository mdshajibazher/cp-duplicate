<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = array(
            array('id' => '1','name' => 'Test Admin','adminname' => 'admin','email' => 'test@gmail.com','phone' => '01700817934','image' => 'md-shajib-azher-2020-06-21.png','email_verified_at' => NULL,'password' => '$2y$10$ZsYR0tQCtOZpVGL4qUSHjun1mY5f.JITq5pVKHomUfVISTVqljF/S','signature' => 'md-shajib-azher-2021-10-10.png','remember_token' => 'JnNzDZIrCzRGBT5PMVgzKNtW0FtVj83OjEIX28BnNtaiIFhqqzU2gR85p8RD','status' => '1','user_id' => NULL,'password_changed' => '1','created_at' => '2020-08-09 00:00:00','updated_at' => '2021-11-25 21:46:26'),
            array('id' => '2','name' => 'Mr Mahmud','adminname' => 'mr-mahmud','email' => 'crescenttradeinta@gmail.com','phone' => '01973358342','image' => 'default.png','email_verified_at' => NULL,'password' => '$2y$10$08D0kZadSuiYCSaGnVV4mu0xGLo6cs7t95U3ENPtCVQFhSgzOr/Fu','signature' => 'mahmud.jpg','remember_token' => 'nkAFupOXRVA3y20ZDEvONyEQX32aFlmmgbGRdEYAGZtq8UPqwAliv4fjHOP5','status' => '1','user_id' => NULL,'password_changed' => '1','created_at' => '2021-10-23 12:19:21','updated_at' => '2022-03-27 23:21:21'),
            array('id' => '5','name' => 'indrajid sorker','adminname' => 'md-rakib','email' => 'sarkerindra72@gmail.com','phone' => '01738056972','image' => 'default.png','email_verified_at' => NULL,'password' => '$2y$10$hl6gGmo8wdGvWn7nEbdBoOhS0I3GBt5SnhWZiSbO0kwmMlbY6Tfge','signature' => NULL,'remember_token' => 'ipPUChXehEKvLLvzsIDKlH87sSkN8sInJs4ipqpWW4xXhUU2QbvWH5Iq9KVn','status' => '1','user_id' => NULL,'password_changed' => '1','created_at' => '2021-10-30 13:25:00','updated_at' => '2022-04-17 02:03:02'),
            array('id' => '6','name' => 'Kahinur Farjana','adminname' => 'kohinurarju5360@gmail.com','email' => 'kohinurarju5360@gmail.com','phone' => '01747646409','image' => 'default.png','email_verified_at' => NULL,'password' => '$2y$10$SsPL.EFj4A1jmjpOeTHnQexza66yBUC2.U3M/ECufAYYF/zuMFmCG','signature' => NULL,'remember_token' => 'rKxUX70gugfxgnahheFNKmzWzLcBQnRHvHSq1dVSQkKhZvxaj0Hd4asx1qZk','status' => '1','user_id' => NULL,'password_changed' => '1','created_at' => '2021-10-30 16:49:45','updated_at' => '2022-04-17 02:09:06'),
            array('id' => '7','name' => 'Md miraj','adminname' => 'md-miraj','email' => 'riyajulislamriyajulislam874@gmail.com','phone' => '01629141086','image' => 'default.png','email_verified_at' => NULL,'password' => '$2y$10$eeP.fYwgc1TsqILf71WtGua3a1VhiY72JUC2F38yUddIXHWOT5VVe','signature' => NULL,'remember_token' => 'P0AqQIedAiX4tjz0dzDHyQCiZ34x7oTzrVKpsRDF5Y2csqMrGkcWBaktyTlj','status' => '1','user_id' => NULL,'password_changed' => '1','created_at' => '2021-11-07 20:23:14','updated_at' => '2021-11-07 20:23:14'),
            array('id' => '8','name' => 'Shakil Ahmed','adminname' => '','email' => 'shakilalshake1234@gmail.com','phone' => '01632375065','image' => 'shakil-ahmed-2021-11-20.jpg','email_verified_at' => NULL,'password' => '$2y$10$YY4ZGcM6LfsbGbSJM.CW0OoJtH.xUsX2.VuqOfSCy4uumsOKhEaJC','signature' => NULL,'remember_token' => 'p0j2mYm1tEaO2NwwBKe420SdwDLUP3ImizyTFWUUVZJG8lu7HzqxM0lgw2q1','status' => '1','user_id' => '314','password_changed' => '1','created_at' => '2021-11-15 17:59:09','updated_at' => '2021-11-20 23:16:19'),
            array('id' => '9','name' => 'Md Noman','adminname' => '','email' => '','phone' => '01884799957','image' => 'default.png','email_verified_at' => NULL,'password' => '$2y$10$f4th1OD35ujbRqmZh48D1.g5.48RP.UPOGZvSRrfzszsRB/6INswe','signature' => NULL,'remember_token' => 'OrtduxqDdbhZcUnZCRPHqXmGAFJkIoPO37OdyYOpWUE0FjUOsjHuw9WHG4J1','status' => '1','user_id' => '293','password_changed' => '1','created_at' => '2021-11-16 12:14:42','updated_at' => '2021-11-18 16:59:42')
        );
        DB::table('admins')->insert($admins);
    }
}
