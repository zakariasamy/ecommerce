<?php

use App\Models\Category;
use Carbon\Factory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(Category::class, 20)->create(); // Call the factory 20 times
    }
}
