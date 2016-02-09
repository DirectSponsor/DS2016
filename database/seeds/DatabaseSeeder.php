<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
//use database\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');

//        $this->call(CertbodyTableSeeder::class);
//
//        $this->call(CategoryTableSeeder::class);
//
//        $this->call(ProducerTableSeeder::class);
//
//        $this->call(ProductsTableSeeder::class);
//
//        $this->call(DistributorsTableSeeder::class);

        Model::reguard();
    }
}
