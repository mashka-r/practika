<?php

use Illuminate\Database\Seeder;
use  App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user0 = new User();
        $user0->name = 'Sam Strand';
        $user0->email = 'sam_strand@gmail.com';
        $user0->password = Hash::make('admin');
        $user0->save();
        $user0->roles()->attach(Role::where('name','Admin')->first());

        $users = factory(User::class, 12)->create()->each(function ($user) {
            $user->roles()->attach(Role::where('name','Registered')->first()); 
        });
        
    }
}
