<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentmethodsTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(GeneralOptionSeeder::class);
        $this->call(ProductSaleSeeder::class);
        $this->call(ReturnProductSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(SmsLogSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(WareHouseSeeder::class);
        $this->call(AdjustSeeder::class);
    }
}
