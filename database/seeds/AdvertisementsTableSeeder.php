<?php

use Illuminate\Database\Seeder;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('advertisements')->insert(['name' => 'Add 1', 'image' => '333333.jpg']);
        DB::table('advertisements')->insert(['name' => 'Add 2', 'image' => '444444.jpg']);
        DB::table('advertisements')->insert(['name' => 'Add 3', 'image' => '555555.jpg']);
        DB::table('advertisements')->insert(['name' => 'Add 4', 'image' => '666666.jpg']);
        DB::table('advertisements')->insert(['name' => 'Add 5', 'image' => '777777.jpg']);
        DB::table('advertisements')->insert(['name' => 'Add 6', 'image' => '888888.jpg']);
    }
}
