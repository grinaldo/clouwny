<?php

use Illuminate\Database\Seeder;
use App\Model\Banner as Model;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Model([
            'image'       => 'images/banner-lg-2.jpg',
            'name'        => 'My Style', 
            'description' => 'A new beginning. A fresh breath of spring to soothe my mind. Keeping me to go around and around in fashinable way',
            'published'   => Carbon::now()
        ]);
        $model->save();

        $model = new Model([
            'image'       => 'images/banner-lg-1.jpg',
            'name'        => 'Sassy Me', 
            'description' => 'Fresh style to pick up your mood and sail away your day until the mister sun is out for the day',
            'published'   => Carbon::now()
        ]);
        $model->save();
    }
}
