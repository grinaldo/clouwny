<?php

use Illuminate\Database\Seeder;
use App\Model\Product as Model;
use App\Model\ProductImage as Variant;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Model::class, 100)
            ->create([
                'published_at' => Carbon::now()
            ])
            ->each(function ($model) {
                $variant = Variant::create([
                    'product_id'  => $model->id,
                    'name'        => 'dummy variant', 
                    'image'       => '',
                    'stock'       => '100',
                    'description' => 'dummy description'
                ]);

                $model->stock = 100;
                $model->save();
            });
    }
}
