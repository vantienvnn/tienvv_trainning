<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Basic 500'
        ]);
        DB::table('categories')->insert([
            'name' => 'Medium 100'
        ]);
    }

}
