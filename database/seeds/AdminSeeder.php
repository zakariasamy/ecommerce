<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::where('email','arabever2@gmail.com')->count();
        if($admin < 1){
        Admin::updateOrCreate([
            'name' => 'zakaria',
            'email' => 'arabever2@gmail.com',
            'password' => Hash::make('1234')
        ]);
        }
    }
}
