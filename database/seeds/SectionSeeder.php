<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = array(
            array('id' => '1','name' => 'Wholesale','module' => 'inventory','created_at' => '2020-09-28 00:00:00','updated_at' => '2020-09-28 00:00:00'),
            array('id' => '2','name' => 'Cosmetics','module' => 'inventory','created_at' => '2020-09-28 00:00:00','updated_at' => '2020-09-28 00:00:00'),
            array('id' => '3','name' => 'Self','module' => 'ecommerce','created_at' => '2020-10-31 06:42:00','updated_at' => '2020-10-31 06:42:00'),
            array('id' => '4','name' => 'Custom','module' => 'ecommerce','created_at' => '2020-10-31 06:42:00','updated_at' => '2020-10-31 06:42:00')
        );

        DB::table('sections')->insert($sections);
    }
}
