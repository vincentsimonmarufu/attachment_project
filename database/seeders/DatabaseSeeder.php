<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\Department;
use App\Models\Jobcard;
use App\Models\Usertype;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\ConnectRelationshipsSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Model::unguard();
        $this->call(UsersTableSeeder::class);
        Model::reguard();
    }
}
