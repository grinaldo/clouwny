<?php

use Illuminate\Database\Seeder;
use App\Model\User as Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Model([
            'name'     => 'admin',
            'role'     => '1',
            'username' => 'admin',
            'email'    => 'admin@admin.com',
            'password' => \Hash::make('admin'),
        ]);
        $model->save();

        $model = new Model([
            'name'     => 'user',
            'role'     => '9',
            'username' => 'user',
            'email'    => 'user@user.com',
            'password' => \Hash::make('password'),
        ]);
        $model->save();

        $faker = Faker\Factory::create();
        $limit = 100;
        for ($i = 0; $i < $limit; $i++) {
            $user = factory(Model::class)->create();
            $user->save();
        }
    }
}
