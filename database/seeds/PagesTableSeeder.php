<?php

use Illuminate\Database\Seeder;
use App\Model\Page as Model;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Model([
            'name'              => 'home-static', 
            'title'             => '<h3>The Story <br> of Our <br> Journey</h3>',
            'short_title'       => 'Natural Beauty',
            'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid velit maiores, eum quibusdam, alias, architecto deleniti recusandae totam hic repellat ipsa cupiditate dolorum iste porro amet voluptatum, incidunt exercitationem dicta!', 
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo dolorum, dignissimos sit id fugit blanditiis, numquam possimus accusamus obcaecati, aspernatur nobis ipsa itaque. Perferendis aperiam excepturi ipsa dolor mollitia numquam.',
        ]);
        $model->save();

        $model = new Model([
            'name'              => 'footer-static', 
            'title'             => 'Company Bio',
            'short_title'       => 'Company Bio',
            'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid velit maiores, eum quibusdam, alias, architecto deleniti recusandae totam hic repellat ipsa cupiditate dolorum iste porro amet voluptatum, incidunt exercitationem dicta!', 
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo dolorum, dignissimos sit id fugit blanditiis, numquam possimus accusamus obcaecati, aspernatur nobis ipsa itaque. Perferendis aperiam excepturi ipsa dolor mollitia numquam.',
        ]);
        $model->save();

        $model = new Model([
            'name'              => 'company-logo', 
            'title'             => 'Company Logo',
            'short_title'       => 'Company Logo',
            'image'             => 'images/logo.png',
            'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid velit maiores, eum quibusdam, alias, architecto deleniti recusandae totam hic repellat ipsa cupiditate dolorum iste porro amet voluptatum, incidunt exercitationem dicta!', 
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo dolorum, dignissimos sit id fugit blanditiis, numquam possimus accusamus obcaecati, aspernatur nobis ipsa itaque. Perferendis aperiam excepturi ipsa dolor mollitia numquam.',
        ]);
        $model->save();

        $model = new Model([
            'name'              => 'about-static', 
            'title'             => 'About Us',
            'short_title'       => 'Clouwny Online Clothing Store',
            'short_description' => '<p>Here in <b>Clouwny</b> we provide the high quality women wears with interesting price for you fashion lovers. We have wide range of collections from dressing, accessories, and so on to fulfill your fashion needs. </p>', 
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo dolorum, dignissimos sit id fugit blanditiis, numquam possimus accusamus obcaecati, aspernatur nobis ipsa itaque. Perferendis aperiam excepturi ipsa dolor mollitia numquam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, iusto eum eveniet vitae temporibus, ab eaque obcaecati voluptatum molestiae itaque pariatur sapiente nam porro ea, tempora autem. Quam, harum. Cum.',
        ]);
        $model->save();
    }
}
