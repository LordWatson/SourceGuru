<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;
use App\Models\ProductSubtype;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productTypes = [
            [
                'name' => 'Broadband',
                'subtypes' => [
                    'ADSL', 'VDSL', 'Fibre to the Cabinet (FTTC)', 'Fibre to the Premises (FTTP)',
                    'Leased Line', '5G Broadband', 'Satellite Broadband', 'Ethernet First Mile (EFM)',
                ],
            ],
            [
                'name' => 'Routers',
                'subtypes' => [
                    'ADSL Router', 'VDSL Router', 'Fibre Router', 'Dual WAN Router',
                    '5G Router', 'Wi-Fi 6 Router', 'Enterprise Router', 'Mesh Router System',
                ],
            ],
            [
                'name' => 'Phone Systems',
                'subtypes' => [
                    'On-Premise PBX', 'Cloud PBX', 'SIP Trunking', 'VoIP Phone System',
                    'Hosted VoIP', 'Hybrid Phone System', 'Virtual Numbers',
                ],
            ],
            [
                'name' => 'Mobile Plans',
                'subtypes' => [
                    'SIM-Only Plan', 'Data-Only Plan', 'Unlimited Data Plan',
                    'PAYG Plan (Pay As You Go)', 'Business Mobile Contract', 'Roaming Plans',
                ],
            ],
            [
                'name' => 'Networking Hardware',
                'subtypes' => [
                    'Network Switch (Unmanaged)', 'Managed Switch', 'PoE Switch',
                    'Firewalls', 'VPN Gateway', 'Access Points', 'Network Extenders',
                ],
            ],
            [
                'name' => 'Cloud Services',
                'subtypes' => [
                    'Cloud Storage', 'Hosted Email', 'Virtual Desktop', 'VPN as a Service',
                    'Backup as a Service (BaaS)', 'Unified Communications (UCaaS)',
                ],
            ],
            [
                'name' => 'Security Solutions',
                'subtypes' => [
                    'Endpoint Security', 'Network Security Appliance', 'Anti-Virus / Anti-Malware',
                    'Email Security Gateway', 'Firewall as a Service (FWaaS)', 'DDoS Protection',
                ],
            ],
            [
                'name' => 'Unified Communications',
                'subtypes' => [
                    'Video Conferencing Solutions', 'Team Collaboration Tools', 'Cloud Contact Center',
                    'Chat Solutions', 'Integrated UC Platform',
                ],
            ],
            [
                'name' => 'Accessories',
                'subtypes' => [
                    'Network Cables', 'Power Supplies', 'Mounting Kits',
                    'Signal Boosters', 'UPS (Uninterruptible Power Supply)',
                ],
            ],
        ];

        foreach($productTypes as $type){
            $productType = ProductType::create(['name' => $type['name']]);

            foreach($type['subtypes'] as $subtype){
                ProductSubtype::create([
                    'product_type_id' => $productType->id,
                    'name' => $subtype,
                ]);
            }
        }
    }
}
