<?php

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('news')->delete();

        News::create([
            'title' => 'Hemasiri, Pujith further remanded',
            'image' => '333333.jpg',
            'desc_1' => 'Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne.',
            'desc_2' => 'Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne. (Shehan Chamika Silva)',
            'is_featured' => true,
        ]);
    }
}
