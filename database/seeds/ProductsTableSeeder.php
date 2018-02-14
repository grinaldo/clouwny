<?php

use Illuminate\Database\Seeder;
use App\Model\Product as Model;
use App\Model\ProductImage as Image;
use App\Model\ProductVariant as Variant;
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
                    'stock'       => '100',
                    'description' => 'dummy description'
                ]);

                $image = Image::create([
                    'product_id'  => $model->id,
                    'image' => 'images/category-'.rand(1,4).'.jpg'
                ]);

                $model->stock = 100;
                $model->save();
            });
    }
}
