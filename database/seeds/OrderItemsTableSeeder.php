<?php

use Illuminate\Database\Seeder;
use App\Model\OrderItem as Model;
use App\Model\Order;
use App\Model\Product;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::pluck('id');
        $models = Order::all();
        foreach ($models as $model) {
            $model->products()->sync([
                $products[rand(0,count($products)-1)],
                $products[rand(0,count($products)-1)],
            ]);
        }
    }
}
