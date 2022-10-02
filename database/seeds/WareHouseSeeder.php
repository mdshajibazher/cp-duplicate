<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = array(
            array('id' => '1','name' => 'Mollika Godown','address' => 'Eastern Mollika,Elephant Road','in_charge' => 'Rakib','created_at' => '2021-11-21 10:14:49','updated_at' => '2021-11-21 10:14:49'),
            array('id' => '2','name' => 'Tropical office','address' => 'Bata signal Elephant Road','in_charge' => 'Rakib','created_at' => '2021-11-21 10:15:19','updated_at' => '2021-11-25 16:59:19')
        );

        DB::table('warehouses')->insert($warehouses);
    }
}
