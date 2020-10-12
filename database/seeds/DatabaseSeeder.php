<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call([
            DistrictsTableSeeder::class,
            UsersTableSeeder::class,
            CompaniesTableSeeder::class,
            AdvertisementsTableSeeder::class,
            NewsTableSeeder::class,
            PostCategoriesTableSeeder::class,
            PostsTableSeeder::class,
            PostCommentsTableSeeder::class,
            ]);
    }
}
