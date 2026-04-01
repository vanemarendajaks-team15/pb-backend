<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Category;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            Group::factory()->count(2)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
