<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@store.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Customers
        $customers = [];
        $names = ['أحمد علي', 'سارة محمد', 'خالد يوسف', 'نور حسن', 'ليلى أحمد'];
        foreach ($names as $i => $name) {
            $customers[] = User::create([
                'name'     => $name,
                'email'    => 'customer' . ($i + 1) . '@store.com',
                'password' => bcrypt('password'),
                'role'     => 'customer',
                'phone'    => '07' . rand(10000000, 99999999),
            ]);
        }

        // Categories
        $phones = Category::create(['name' => 'الهواتف', 'slug' => 'phones']);
        $tablets = Category::create(['name' => 'التابلت', 'slug' => 'tablets']);
        $accessories = Category::create(['name' => 'الإكسسوارات', 'slug' => 'accessories']);

        // Products
        $productData = [
            ['name' => 'Samsung Galaxy S22 Ultra', 'price' => 1780, 'stock' => 15, 'category_id' => $phones->id, 'is_featured' => true],
            ['name' => 'iPhone 15 Pro Max',        'price' => 1950, 'stock' => 10, 'category_id' => $phones->id, 'is_featured' => true],
            ['name' => 'Camon 30 Premier',         'price' => 650,  'stock' => 20, 'category_id' => $phones->id],
            ['name' => 'iPad Pro 12.9',            'price' => 1200, 'stock' => 8,  'category_id' => $tablets->id],
            ['name' => 'Samsung Galaxy Tab S9',    'price' => 900,  'stock' => 12, 'category_id' => $tablets->id],
            ['name' => 'Eufy Clean L60',           'price' => 480,  'stock' => 5,  'category_id' => $accessories->id],
            ['name' => 'AirPods Pro 2',            'price' => 249,  'stock' => 30, 'category_id' => $accessories->id],
        ];

        $products = [];
        foreach ($productData as $data) {
            $data['slug'] = Str::slug($data['name']);
            $products[] = Product::create($data);
        }

        // Orders
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        foreach ($customers as $customer) {
            $order = Order::create([
                'user_id'          => $customer->id,
                'status'           => $statuses[array_rand($statuses)],
                'total'            => 0,
                'shipping_address' => 'عمان، الأردن',
                'payment_method'   => 'cash',
            ]);

            $total = 0;
            $selected = array_rand($products, 2);
            foreach ((array)$selected as $idx) {
                $qty   = rand(1, 3);
                $price = $products[$idx]->price;
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $products[$idx]->id,
                    'quantity'   => $qty,
                    'unit_price' => $price,
                ]);
                $total += $qty * $price;
            }
            $order->update(['total' => $total]);
        }

        // Reviews
        foreach ($products as $product) {
            foreach (array_rand($customers, 3) as $idx) {
                Review::create([
                    'user_id'    => $customers[$idx]->id,
                    'product_id' => $product->id,
                    'rating'     => rand(3, 5),
                    'body'       => 'منتج ممتاز وجودة عالية',
                    'status'     => 'approved',
                ]);
            }
        }

    }
}
