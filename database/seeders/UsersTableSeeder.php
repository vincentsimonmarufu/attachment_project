<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser = User::where('name','=','vmarufu')->first();
        if($newUser === null){
            $newUser = User::create([
                'name'     => 'vmarufu',
                'email'    => 'itgt@whelson.co.zw',
                'password' => bcrypt('password')
            ]);
            $newUser->save();
        }
    }
}
