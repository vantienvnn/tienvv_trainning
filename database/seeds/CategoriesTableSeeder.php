<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    use MasterTableTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [
                'id' => 1,
                'name' => 'Basic 500'
            ],
            [
                'id' => 2,
                'name' => 'Medium 100'
            ]
        ];
        $this->insertIgnoreRecords('categories', $records);
    }

}
