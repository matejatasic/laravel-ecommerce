<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Lapotops',
                'slug' => 'laptops',
            ],
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile_phones',
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
            ],
            [
                'name' => 'PCs',
                'slug' => 'pcs',
            ],
            [
                'name' => 'TVs',
                'slug' => 'tvs',
            ],
        ];

        foreach($categories as $category) {
            Category::create($category);
        }
    }
}
