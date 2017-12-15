<?php

use Illuminate\Database\Seeder;
use App\Model\SocialMedia as model;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Model([
            'name' => 'facebook',
            'url'  => 'https://facebook.com/your-url'
        ]);
        $model->save();
        
        $model = new Model([
            'name' => 'instagram',
            'url'  => 'https://instagram.com/your-url'
        ]);
        $model->save();

        $model = new Model([
            'name' => 'twitter',
            'url'  => 'https://twitter.com/your-url'
        ]);
        $model->save();

        $model = new Model([
            'name' => 'line',
            'url'  => '@something'
        ]);
        $model->save();

        $model = new Model([
            'name' => 'whatsapp',
            'url'  => 'tel:080989999'
        ]);
        $model->save();
    }
}
