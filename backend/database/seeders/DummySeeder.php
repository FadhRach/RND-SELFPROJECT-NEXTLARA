<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Product_categories;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat kategori
        $kategori = Product_categories::create([
            'name_categories' => 'Elektronik',
        ]);

        // 3. Buat 2 user: admin & customer
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'user@example.com',
            'telephone' => '082222222222',
            'address' => 'Jl. User No.2',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'telephone' => '081111111111',
            'address' => 'Jl. Admin No.1',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Buat 5 produk dummy dalam kategori ini
        $products = Product::factory()->count(5)->create([
            'id_category' => $kategori->id_categories,
            'product_status' => 'available',
            'id_user' => $admin->id_user,
        ]);

        // 4. Buat payment dummy
        $payment = Payment::create([
            'payment_date' => now(),
            'total_price' => 500000,
            'payment_method' => 'Transfer Bank',
        ]);

        // 5. Buat order untuk customer
        $order = Order::create([
            'id_user' => $customer->id_user, // <- fix disini, jangan pake $user yg belum ada
            'id_payment' => $payment->id_payment,
            'order_status' => 'pending',
            'order_date' => now(),
            'shipping' => 'JNE',
        ]);

        // 6. Buat order detail dari 2 produk pertama
        foreach ($products->take(2) as $product) {
            Order_detail::create([
                'id_order' => $order->id_order,
                'id_product' => $product->id_product,
                'quantity' => 2,
                'price' => $product->price,
            ]);
        }

    }
}
