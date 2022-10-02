<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplierdues = array(
            array('id' => '1','amount' => '20000.00','supplier_id' => '25','reference' => 'Mrdical','admin_id' => '2','due_at' => '2022-02-12 15:21:51','created_at' => '2022-02-12 15:21:51','updated_at' => '2022-02-12 15:21:51')
        );

        /* `cp`.`suppliers` */
        $suppliers = array(
            array('id' => '1','name' => 'Purchase','company' => 'Demo Comapny','address' => 'Dhaka','email' => 'info@example.com','phone' => '01700554466','created_at' => '2020-06-14 00:10:18','updated_at' => '2020-12-10 15:53:57'),
            array('id' => '25','name' => 'Md A Salam','company' => 'Vision Trade','address' => 'Elephant Road','email' => NULL,'phone' => '01736402322','created_at' => '2021-11-25 18:50:12','updated_at' => '2021-11-25 18:50:12'),
            array('id' => '26','name' => 'Md Shohel','company' => 'Trust labretory','address' => 'Siera shelteck,batasignal','email' => NULL,'phone' => '01711226823','created_at' => '2022-04-23 04:45:09','updated_at' => '2022-04-23 04:45:09')
        );

        DB::table('suppliers')->insert($suppliers);
        DB::table('supplierdues')->insert($supplierdues);

    }
}
