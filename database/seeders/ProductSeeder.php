<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Golden Crust (brand_id: 1)
            ['brand_id' => 1, 'product_name' => 'Sourdough Classic', 'description' => 'Roti sourdough artisan dengan fermentasi alami 24 jam, kulit renyah dan dalam yang lembut.', 'price' => 45000, 'stock' => 50],
            ['brand_id' => 1, 'product_name' => 'French Baguette', 'description' => 'Baguette panjang crispy khas Prancis, cocok untuk sandwich atau disantap dengan mentega.', 'price' => 25000, 'stock' => 100],
            ['brand_id' => 1, 'product_name' => 'Ciabatta Loaf', 'description' => 'Roti ciabatta Italia dengan pori-pori besar dan tekstur chewy yang menggugah selera.', 'price' => 38000, 'stock' => 40],

            // Sweet Heaven (brand_id: 2)
            ['brand_id' => 2, 'product_name' => 'Cinnamon Roll', 'description' => 'Gulungan kayu manis lembut dengan topping cream cheese frosting yang manis dan creamy.', 'price' => 18000, 'stock' => 80],
            ['brand_id' => 2, 'product_name' => 'Chocolate Muffin', 'description' => 'Muffin cokelat moist dengan chocolate chips di setiap gigitan, favorit anak-anak.', 'price' => 15000, 'stock' => 120],
            ['brand_id' => 2, 'product_name' => 'Red Velvet Cake Slice', 'description' => 'Sepotong red velvet cake lembut dengan cream cheese frosting yang kaya dan elegant.', 'price' => 28000, 'stock' => 30],
            ['brand_id' => 2, 'product_name' => 'Banana Bread', 'description' => 'Roti pisang moist dan wangi, dibuat dari pisang matang pilihan dengan kacang walnut.', 'price' => 32000, 'stock' => 60],

            // Whole Grain Co. (brand_id: 3)
            ['brand_id' => 3, 'product_name' => 'Multi Grain Bread', 'description' => 'Roti gandum utuh dengan campuran 7 biji-bijian bergizi, tinggi serat dan rendah GI.', 'price' => 42000, 'stock' => 45],
            ['brand_id' => 3, 'product_name' => 'Oat Bread', 'description' => 'Roti gandum oat yang lembut dan mengenyangkan, bebas pengawet dan tambahan gula.', 'price' => 35000, 'stock' => 55],
            ['brand_id' => 3, 'product_name' => 'Rye Bread', 'description' => 'Roti rye (gandum hitam) padat bergizi dari Eropa Utara, cocok untuk diet sehat.', 'price' => 48000, 'stock' => 25],

            // Croissant & Co. (brand_id: 4)
            ['brand_id' => 4, 'product_name' => 'Butter Croissant', 'description' => 'Croissant mentega klasik dengan 27 lapisan sempurna, renyah di luar lembut di dalam.', 'price' => 22000, 'stock' => 90],
            ['brand_id' => 4, 'product_name' => 'Pain au Chocolat', 'description' => 'Croissant isi cokelat dark premium Belgia, pilihan sempurna untuk sarapan mewah.', 'price' => 25000, 'stock' => 70],
            ['brand_id' => 4, 'product_name' => 'Almond Croissant', 'description' => 'Croissant isi krim almond dengan taburan irisan almond panggang dan gula halus.', 'price' => 28000, 'stock' => 50],

            // Local Bakehouse (brand_id: 5)
            ['brand_id' => 5, 'product_name' => 'Roti Unyil', 'description' => 'Roti mini lucu dengan berbagai isian: cokelat, keju, sosis, dan selai strawberry.', 'price' => 8000, 'stock' => 200],
            ['brand_id' => 5, 'product_name' => 'Roti Sobek Pandan', 'description' => 'Roti sobek wangi pandan dengan isian kelapa muda dan gula aren, resep tradisional.', 'price' => 22000, 'stock' => 80],
            ['brand_id' => 5, 'product_name' => 'Roti Kasur Susu', 'description' => 'Roti kasur lembut isian susu kental manis, tekstur fluffy seperti awan.', 'price' => 18000, 'stock' => 100],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}