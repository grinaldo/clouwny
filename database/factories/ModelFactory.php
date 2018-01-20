<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Model\User::class, function (Faker\Generator $faker) {
    static $password;

    $firstName = $faker->firstName;
    $lastName  = $faker->lastName;
    $gender    = ['male', 'female'];

    return [
        'name'           => $firstName.' '.$lastName,
        'role'           => '9',
        'username'       => strtolower($firstName.'.'.$lastName),
        'email'          => $faker->unique()->safeEmail,
        'password'       => \Hash::make('secret'),
        'gender'         => $gender[rand(0,1)],
        'birthday'       => $faker->date('Y-m-d'),
        'province'       => $faker->city,
        'district'       => $faker->city,
        'address'        => $faker->address,
        'zipcode'        => (string)rand(10000,99999),
        'active'         => true,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\Product::class, function (Faker\Generator $faker) {
    $auxiliary = ['Special', 'Youthful', 'Brimming', 'Cheerful', 'Bright', 'Sassy'];
    $item      = ['Clothing', 'Fashion', 'Wear', 'Outfit'];
    $auxId     = rand(0,count($auxiliary)-1);
    $itemId    = rand(0,count($item)-1);
    $itemName  = $faker->firstName . ' ' . $auxiliary[$auxId] . ' ' . $item[$itemId];
    $itemSlug  = str_replace(' ', '-', $itemName);
    $image     = ['images/product-1.jpg', 'images/product-2.jpg'];
    return [
        'category_id'       => rand(1,9),
        'name'              => $itemName,
        'slug'              => $itemSlug,
        'stock'             => 100,
        'image'             => $image[rand(0,1)],
        'price'             => rand(20000,200000),
        'price'             => rand(50000,300000),
        'actual_price'      => rand(20000,300000),
        'is_featured'       => rand(0,1),
        'short_description' => 'Lorem ipsum dolor sit amet consectetur sto',
        'description'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi consequuntur possimus ullam iste nobis unde deleniti officia, dolorum! Debitis fuga, adipisci consequuntur, in explicabo quibusdam est officia ut doloribus quis?'  
    ];
});

$factory->define(App\Model\Order::class, function (Faker\Generator $faker) {
    $shipperName  = $faker->firstName . ' ' . $faker->lastName;
    $receiverName = $faker->firstName . ' ' . $faker->lastName;
    $shipmentType = ['regular', 'next-day', 'same-day', 'express'];
    $payment_method = ['transfer', 'wallet'];
    return [
        'user_id' => rand(1,100),
        'is_dropship' => rand(0,1),
        'delivery_company' => 'sicepat',
        'delivery_type' => $shipmentType[rand(0,count($shipmentType)-1)],
        'shipping_fee' => rand(10000,99999),
        'total_fee' => rand(50000,99999),
        'shipper_name' => $shipperName,
        'shipper_phone' => $faker->phoneNumber,
        'shipper_email' => $faker->email,
        'shipper_province' => $faker->city,
        'shipper_city' => $faker->city,
        'shipper_district' => $faker->city,
        'shipper_zipcode' => (string)rand(10000,99999),
        'shipper_address' => $faker->address,
        'receiver_name' => $receiverName,
        'receiver_phone' => $faker->phoneNumber,
        'receiver_email' => $faker->email,
        'receiver_province' => $faker->city,
        'receiver_city' => $faker->city,
        'receiver_district' => $faker->city,
        'receiver_zipcode' => (string)rand(10000,99999),
        'receiver_address' => $faker->address,
        'payment_method' => $payment_method[rand(0,1)]
    ];
});