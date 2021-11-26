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
                'name' => 'Lapotops'
            ],
            [
                'name' => 'Mobile Phones'
            ],
            [
                'name' => 'Tablets'
            ],
            [
                'name' => 'PCs'
            ],
            [
                'name' => 'TVs'
            ],
        ];

        foreach($categories as $category) {
            Category::create($category);
        }
    }
}
