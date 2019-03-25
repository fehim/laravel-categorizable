<?php

namespace hcivelek\Categorizable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use \hcivelek\Categorizable\Entities\Category;

class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = ["Life","Education","Technology","Economy","Developing"];

        foreach($categories as $category)
            Category::create([
                'name' => $category
            ]);        
                
    }
}
