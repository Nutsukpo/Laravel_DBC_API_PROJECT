<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'isaac',
            'email' => 'isaac@test.com',
            'contact' => '0542013350',
            'password' => 'test123'
        ]);

        // // user::create ([
        // // 'name' => 'SYSTEM ADMIN',
        // // 'email' => 'admin@test.com',
        // // 'contact' => '0542013350',
        // // 'password' => 'password'
        // // ]);
        // user::create ([
        //     'name' => ' NUTSUKPO ELVIS KOJO',
        //     'email' => 'e.nutsukpo@gmail.com',
        //     'contact' => '0542013350',
        //     'password' => 'Mon@0542013350'
        // ]);

    }
}
