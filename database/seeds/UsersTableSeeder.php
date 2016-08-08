<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'name' => 'Demo',
                'email' => 'demo@gmail.com',
                'password' => bcrypt('demo'),
            ]
        ];
        $this->insertIgnoreRecords('users', $records);
    }

}
