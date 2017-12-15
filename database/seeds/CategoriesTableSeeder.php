<?php

use Illuminate\Database\Seeder;
use App\Model\Category as Model;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Model([
            'name'          => 'Dress',
            'slug'          => 'dress',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Batik',
            'slug'          => 'batik',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Outerwear',
            'slug'          => 'outerwear',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Jumpsuit',
            'slug'          => 'jumpsuit',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Shirt',
            'slug'          => 'shirt',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Skirt',
            'slug'          => 'skirt',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Pants',
            'slug'          => 'pants',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Bag',
            'slug'          => 'bag',
            'published_at'  => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'name'          => 'Accessory',
            'slug'          => 'accessory',
            'published_at'  => Carbon::now()
        ]);
        $model->save();
    }
}
