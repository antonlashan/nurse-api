<?php

/**
 * Description of DistrictsTableSeeder.
 *
 * @author lashanfernando
 */
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('districts')->delete();

        District::create(['name' => 'Ampara']);
        District::create(['name' => 'Anuradhapura']);
        District::create(['name' => 'Badulla']);
        District::create(['name' => 'Batticaloa']);
        District::create(['name' => 'Colombo']);
        District::create(['name' => 'Galle']);
        District::create(['name' => 'Gampaha']);
        District::create(['name' => 'Hambantota']);
        District::create(['name' => 'Jaffna']);
        District::create(['name' => 'Kalutara']);
        District::create(['name' => 'Kandy']);
        District::create(['name' => 'Kegalle']);
        District::create(['name' => 'Kilinochchi']);
        District::create(['name' => 'Kurunegala']);
        District::create(['name' => 'Mannar']);
        District::create(['name' => 'Matale']);
        District::create(['name' => 'Matara']);
        District::create(['name' => 'Monaragala']);
        District::create(['name' => 'Mullaitivu']);
        District::create(['name' => 'Nuwara Eliya']);
        District::create(['name' => 'Polonnaruwa']);
        District::create(['name' => 'Puttalam']);
        District::create(['name' => 'Ratnapura']);
        District::create(['name' => 'Trincomalee']);
        District::create(['name' => 'Vavuniya']);
    }
}
