<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create(), save(), categoryMany()
        // insert()
        $categories = [
            [
                'name' => 'Wellness',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Current Events',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Fashion Trends',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
        ];

        $this->category->insert($categories);
    }
}
