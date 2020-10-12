<?php

/**
 * Description of PostCategoriesTableSeeder.
 *
 * @author lashanfernando
 */
use Illuminate\Database\Seeder;
use App\Models\PostCategory;

class PostCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('post_categories')->delete();

        PostCategory::create(['name' => 'Category 1']);
        PostCategory::create(['name' => 'Category 2']);
        PostCategory::create(['name' => 'Category 3']);
        PostCategory::create(['name' => 'Category 4']);
        PostCategory::create(['name' => 'Category 5']);
        PostCategory::create(['name' => 'Category 6']);
    }
}
