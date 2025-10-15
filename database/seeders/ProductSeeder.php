<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample drink products
        Product::create([
            'category' => 'minuman',
            'title' => 'Cappuccino',
            'description' => 'Kopi espresso dengan susu steam dan busa susu yang lembut, ditaburi dengan bubuk cokelat.',
            'price' => 25000,
        ]);

        Product::create([
            'category' => 'minuman',
            'title' => 'Caffe Latte',
            'description' => 'Kopi espresso dengan susu steam yang creamy, sempurna untuk menemani hari Anda.',
            'price' => 28000,
        ]);

        Product::create([
            'category' => 'minuman',
            'title' => 'Mocha',
            'description' => 'Perpaduan sempurna antara kopi espresso, susu, dan cokelat yang kaya.',
            'price' => 30000,
        ]);

        Product::create([
            'category' => 'minuman',
            'title' => 'Espresso',
            'description' => 'Kopi murni yang kuat dan intens, disajikan dalam cangkir kecil.',
            'price' => 20000,
        ]);

        Product::create([
            'category' => 'minuman',
            'title' => 'Americano',
            'description' => 'Espresso yang diencerkan dengan air panas, memberikan rasa kopi yang murni namun lebih ringan.',
            'price' => 22000,
        ]);

        Product::create([
            'category' => 'minuman',
            'title' => 'Macchiato',
            'description' => 'Espresso dengan sedikit susu steam dan busa susu di atasnya.',
            'price' => 27000,
        ]);

        // Sample food products
        Product::create([
            'category' => 'makanan',
            'title' => 'Croissant',
            'description' => 'Pastry buttery yang renyah dengan lapisan-lapisan yang sempurna.',
            'price' => 25000,
        ]);

        Product::create([
            'category' => 'makanan',
            'title' => 'Sandwich Club',
            'description' => 'Roti panggang dengan ayam, bacon, lettuce, tomat, dan mayonnaise.',
            'price' => 45000,
        ]);

        Product::create([
            'category' => 'makanan',
            'title' => 'Caesar Salad',
            'description' => 'Sayuran segar dengan dressing Caesar, crouton, dan parmesan cheese.',
            'price' => 40000,
        ]);

        Product::create([
            'category' => 'makanan',
            'title' => 'Chocolate Cake',
            'description' => 'Kue cokelat yang lembab dan kaya dengan lapisan cokelat ganache.',
            'price' => 35000,
        ]);

        Product::create([
            'category' => 'makanan',
            'title' => 'Blueberry Muffin',
            'description' => 'Muffin yang lembut dengan blueberry segar di dalamnya.',
            'price' => 22000,
        ]);

        Product::create([
            'category' => 'makanan',
            'title' => 'Bagel dengan Cream Cheese',
            'description' => 'Bagel panggang yang lezat dengan olesan cream cheese dan irisan salmon.',
            'price' => 38000,
        ]);
    }
}
