<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = array(
            array('id' => '1','brand_name' => 'Crescent Pharma','image' => NULL,'frontend' => '0','created_at' => '2021-10-20 07:44:30','updated_at' => '2021-10-20 07:44:30'),
            array('id' => '2','brand_name' => 'Almonex A Lotion','image' => NULL,'frontend' => '0','created_at' => '2021-11-21 20:32:19','updated_at' => '2021-11-21 20:32:19')
        );
        DB::table('brands')->insert($brands);
    }
}
