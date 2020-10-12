<?php

/**
 * Description of UsersTableSeeder.
 *
 * @author lashanfernando
 */
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->delete();

        $user = User::create(['email' => 'admin@nurse.com', 'mobile_no' => '1234567890', 'password' => '$2y$10$9GASpInojH62kNqPDnq/o.Goo9fueEM3DEWb9d19q3uVPHZjyMLhu', 'role' => 'admin', 'is_active' => true]);
        $user->userDetail()->create(['first_name' => 'Admin', 'gender' => 'male', 'is_complete_profile' => false, 'dob' => '1985-01-01']);

        $user = User::create(['email' => 'client@nurse.com', 'mobile_no' => '1234567891', 'password' => '$2y$10$9GASpInojH62kNqPDnq/o.Goo9fueEM3DEWb9d19q3uVPHZjyMLhu', 'role' => 'client', 'is_active' => true]);
        $user->userDetail()->create([
            'first_name' => 'Sean',
            'last_name' => 'Marshall',
            'gender' => 'male',
            'is_complete_profile' => false,
            'dob' => '1985-01-02',
            ]);

        $user = User::create(['email' => 'john.edmunds@nurse.com', 'mobile_no' => '1234567892', 'password' => '$2y$10$9GASpInojH62kNqPDnq/o.Goo9fueEM3DEWb9d19q3uVPHZjyMLhu', 'role' => 'client', 'is_active' => true]);
        $user->userDetail()->create([
            'first_name' => 'John',
            'last_name' => 'Edmunds',
            'gender' => 'male',
            'is_complete_profile' => false,
            'dob' => '1985-01-02',
            ]);

        $user = User::create(['email' => 'sophie.manning@nurse.com', 'mobile_no' => '1234567893', 'password' => '$2y$10$9GASpInojH62kNqPDnq/o.Goo9fueEM3DEWb9d19q3uVPHZjyMLhu', 'role' => 'client', 'is_active' => true]);
        $user->userDetail()->create([
            'first_name' => 'Sophie',
            'last_name' => 'Manning',
            'gender' => 'female',
            'is_complete_profile' => false,
            'dob' => '1985-01-02',
            ]);

        $user = User::create(['email' => 'rebecca.hunter@nurse.com', 'mobile_no' => '1234567895', 'password' => '$2y$10$9GASpInojH62kNqPDnq/o.Goo9fueEM3DEWb9d19q3uVPHZjyMLhu', 'role' => 'client', 'is_active' => true]);
        $user->userDetail()->create([
            'first_name' => 'Rebecca',
            'last_name' => 'Hunter',
            'gender' => 'female',
            'is_complete_profile' => false,
            'dob' => '1985-01-02',
            ]);
    }
}
