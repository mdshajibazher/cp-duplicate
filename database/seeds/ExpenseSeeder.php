<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expensecategories = array(
            array('id' => '1','name' => 'Office','created_at' => '2021-11-02 08:02:18','updated_at' => '2021-11-02 08:02:18'),
            array('id' => '2','name' => 'Personal','created_at' => '2021-11-02 08:02:43','updated_at' => '2021-11-02 08:02:43'),
            array('id' => '3','name' => 'Tea','created_at' => '2021-11-25 18:10:29','updated_at' => '2021-11-25 18:10:29'),
            array('id' => '4','name' => 'Dr Gift','created_at' => '2021-11-25 18:34:19','updated_at' => '2021-11-25 18:34:19'),
            array('id' => '5','name' => 'Salam v','created_at' => '2022-01-12 15:46:05','updated_at' => '2022-01-12 15:46:05')
        );

        /* `cp`.`expenses` */
        $expenses = array(
            array('id' => '1','expense_date' => '2021-11-25 00:00:00','reasons' => '.','amount' => '100.00','admin_id' => '2','expensecategory_id' => '3','created_at' => '2021-11-25 18:11:00','updated_at' => '2021-11-25 18:11:00','deleted_at' => NULL),
            array('id' => '2','expense_date' => '2021-11-25 00:00:00','reasons' => 'Shakil','amount' => '200.00','admin_id' => '2','expensecategory_id' => '4','created_at' => '2021-11-25 18:39:42','updated_at' => '2021-11-25 18:39:42','deleted_at' => NULL),
            array('id' => '3','expense_date' => '2022-01-12 00:00:00','reasons' => 'Salam v,','amount' => '37000.00','admin_id' => '2','expensecategory_id' => '2','created_at' => '2022-01-12 15:44:15','updated_at' => '2022-01-12 15:44:15','deleted_at' => NULL),
            array('id' => '4','expense_date' => '2022-01-16 00:00:00','reasons' => 'Fertimaid babod','amount' => '50000.00','admin_id' => '2','expensecategory_id' => '5','created_at' => '2022-01-18 23:41:18','updated_at' => '2022-01-18 23:41:18','deleted_at' => NULL)
        );

        DB::table('expensecategories')->insert($expensecategories);
        DB::table('expenses')->insert($expenses);
    }
}
