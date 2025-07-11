<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductSubtype;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Fibre Broadband 100 Mbps',
                'description' => 'High-speed internet connection with 100 Mbps download speed.',
                'image' => 'fibre_broadband.jpg',
                'product_type_name' => 'Broadband',
                'product_sub_type_name' => 'Fibre to the Cabinet (FTTC)',
                'unit_buy_price' => 30.00,
                'unit_sell_price' => 45.00,
            ],
            [
                'name' => 'Enterprise Router AX6000',
                'description' => 'High-performance enterprise router with advanced features.',
                'image' => 'enterprise_router.jpg',
                'product_type_name' => 'Routers',
                'product_sub_type_name' => 'Enterprise Router',
                'unit_buy_price' => 200.00,
                'unit_sell_price' => 300.00,
            ],
            [
                'name' => 'VoIP Phone System Pro',
                'description' => 'Reliable VoIP phone system with cloud integration.',
                'image' => 'voip_phone.jpg',
                'product_type_name' => 'Phone Systems',
                'product_sub_type_name' => 'VoIP Phone System',
                'unit_buy_price' => 150.00,
                'unit_sell_price' => 250.00,
            ],
            [
                'name' => 'Unlimited Data SIM Plan',
                'description' => 'Unlimited data mobile plan with 5G support.',
                'image' => 'unlimited_data_sim.jpg',
                'product_type_name' => 'Mobile Plans',
                'product_sub_type_name' => 'Unlimited Data Plan',
                'unit_buy_price' => 10.00,
                'unit_sell_price' => 25.00,
            ],
            [
                'name' => 'Managed Network Switch',
                'description' => 'Managed Switch for corporate networking environments.',
                'image' => 'managed_switch.jpg',
                'product_type_name' => 'Networking Hardware',
                'product_sub_type_name' => 'Managed Switch',
                'unit_buy_price' => 100.00,
                'unit_sell_price' => 150.00,
            ],
            [
                'name' => 'BaaS Backup Solution',
                'description' => 'Backup as a Service for safeguarding your data.',
                'image' => 'baas_solution.jpg',
                'product_type_name' => 'Cloud Services',
                'product_sub_type_name' => 'Backup as a Service (BaaS)',
                'unit_buy_price' => 50.00,
                'unit_sell_price' => 75.00,
            ],
            [
                'name' => 'Firewall Appliance',
                'description' => 'Advanced network security appliance for businesses.',
                'image' => 'firewall_appliance.jpg',
                'product_type_name' => 'Security Solutions',
                'product_sub_type_name' => 'Network Security Appliance',
                'unit_buy_price' => 250.00,
                'unit_sell_price' => 350.00,
            ],
            [
                'name' => 'Video Conferencing Solution',
                'description' => 'All-in-one video conferencing package.',
                'image' => 'video_conferencing.jpg',
                'product_type_name' => 'Unified Communications',
                'product_sub_type_name' => 'Video Conferencing Solutions',
                'unit_buy_price' => 400.00,
                'unit_sell_price' => 500.00,
            ],
            [
                'name' => 'Network Power Supply',
                'description' => 'Reliable power supply for networking hardware.',
                'image' => 'power_supply.jpg',
                'product_type_name' => 'Accessories',
                'product_sub_type_name' => 'Power Supplies',
                'unit_buy_price' => 50.00,
                'unit_sell_price' => 75.00,
            ],
        ];

        foreach($products as $product){
            /*
             * find the product (and sub) types
             * I could've added id's into the array to seed, but string names are easier for readability
             * */
            $productType = ProductType::where('name', $product['product_type_name'])->first();
            $productSubtype = ProductSubtype::where('name', $product['product_sub_type_name'])
                ->where('product_type_id', $productType->id)
                ->first();

            // create
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'image' => $product['image'],
                'product_type_id' => $productType->id,
                'product_sub_type_id' => $productSubtype->id,
                'unit_buy_price' => $product['unit_buy_price'],
                'unit_sell_price' => $product['unit_sell_price'],
            ]);
        }
    }
}
