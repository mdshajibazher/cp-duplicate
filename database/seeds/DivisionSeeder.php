<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = array(
            array('id' => '1','name' => 'Chattagram','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '2','name' => 'Rajshahi','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '3','name' => 'Khulna','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '4','name' => 'Barisal','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '5','name' => 'Sylhet','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '6','name' => 'Dhaka','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '7','name' => 'Rangpur','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54'),
            array('id' => '8','name' => 'Mymensingh','created_at' => '2020-06-12 21:44:54','updated_at' => '2020-06-12 21:44:54')
        );
        DB::table('divisions')->insert($divisions);

    }
}
