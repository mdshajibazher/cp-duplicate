<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = array(
            array('id' => '1','company_name' => 'Crescent Pharma','address' => 'Tropical Center, 10th floor,Bata signal Elephant Road Dhaka','email' => 'crescentpharma@gmail.com','phone' => '01973358342','bin' => '000466013-0201','social' => '{"facebook":["#","0"],"twitter":["#","1"],"pinterest":["#","1"],"linkedin":["#","1"]}','logo' => 'crescent-pharma_logo_17_2021-10-22.png','favicon' => 'crescent-pharma_favicon_40_2021-10-22.png','og_image' => 'crescent-pharma_og_image_40_2021-10-22.png','tagline' => 'Experience the difference.','short_description' => '.','map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.247858915142!2d90.38346211452391!3d23.738539184595144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b9295263eb59%3A0x64f7bc58ad273d7a!2sVision%20Mart!5e0!3m2!1sen!2sbd!4v1604025427508!5m2!1sen!2sbd"  height="400" frameborder="0" style="border:0;"  allowfullscreen="false" aria-hidden="true" tabindex="0"></iframe>','created_at' => '2020-06-12 15:44:55','updated_at' => '2021-10-22 06:25:09')
        );

        DB::table('companies')->insert($companies);
    }
}
