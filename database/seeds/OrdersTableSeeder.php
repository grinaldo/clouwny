<?php

use Illuminate\Database\Seeder;
use App\Model\Order as Model;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Model::class, 10)->create();
    }
}
