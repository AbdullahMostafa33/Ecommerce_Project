<?php




namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $sections = [
            'Men\'s Shoes' => ['Nike Air Max', 'Adidas Ultraboost', 'Puma RS-X', 'Reebok Classic', 'New Balance 990', 'Converse Chuck Taylor', 'Under Armour HOVR', 'Asics Gel-Kayano', 'Saucony Triumph', 'Vans Old Skool'],
            'Women\'s Shoes' => ['Nike Air Force 1', 'Adidas Stan Smith', 'Puma Cali', 'Reebok Club C', 'New Balance 574', 'Converse Chuck 70', 'Under Armour Charged', 'Asics Gel-Nimbus', 'Saucony Shadow', 'Vans Sk8-Hi'],
            'Kid\'s Shoes' => ['Nike Air Max Kids', 'Adidas Superstar Kids', 'Puma Future Rider Kids', 'Reebok Royal BB4500 Kids', 'New Balance 373 Kids', 'Converse All Star Kids', 'Under Armour Micro G', 'Asics Gel-Cumulus Kids', 'Saucony Peregrine Kids', 'Vans Authentic Kids'],
            'Sports' => ['Nike Running Shoes', 'Adidas Training Shoes', 'Puma Soccer Cleats', 'Reebok Basketball Shoes', 'New Balance Trail Shoes', 'Converse Sports Shoes', 'Under Armour Gym Shoes', 'Asics Running Sneakers', 'Saucony Cross Training', 'Vans Skate Shoes'],
            'Accessories' => ['Nike Sports Bag', 'Adidas Cap', 'Puma Socks', 'Reebok Wristbands', 'New Balance Sunglasses', 'Converse Belt', 'Under Armour Backpack', 'Asics Sports Watch', 'Saucony Water Bottle', 'Vans Keychain'],
        ];

        foreach ($sections as $section => $products) {
            $sectionId = DB::table('sections')->where('name', $section)->first()->id;

            foreach ($products as $product) {
                DB::table('products')->insert([
                    'name' => $product,
                    'description' => $faker->sentence(10),
                    'image' => 'path/to/your/image.jpg', // Replace with actual image path
                    'price' => $faker->randomFloat(2, 10, 100),
                    'section_id' => $sectionId,
                ]);
            }
        }
    }
}


