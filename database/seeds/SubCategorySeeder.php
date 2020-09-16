<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::select('id')->get();
        factory(Category::class, 10)->create([
            'parent_id' => $categories->random(),
        ]);
    }
}
