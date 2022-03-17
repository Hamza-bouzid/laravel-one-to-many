<?php

use Illuminate\Database\Seeder;
use App\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['cinema', 'sport', 'cucina', 'politica', 'intrattenimento' ];
        foreach($categories as $category_name) {
            $new_gategory = new Category();
            $new_gategory->name = $category_name;
            $new_gategory->slug = Str::of($category_name)->slug("-");
            $new_gategory->save();
        }
    }
}
