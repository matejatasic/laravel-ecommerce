<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Microsoft Surface',
                'image' => 'microsoft_surface.png',
                'slug' => 'microsoft_surface',
                'details' => '12.4" 1536 x 1024, 8GB LPDDR4x',
                'description' => '
                    Power to do what you want with up to 70% more speed and multitasking power than before and exclusive AMD Ryzen™ Microsoft Surface® Edition processor.
                    Thin, light, elegant design with the light, portable 13.5”.
                    Show your best side on video calls with sharp video and image quality, even in low light, thanks to a front-facing 720p HD camera.
                ',
                'price' => 1199,
                'featured' => true,
                'category_id' => 1,

            ],
            [
                'name' => 'Asus E410',
                'image' => 'asus_e410.png',
                'slug' => 'asus_e410',
                'details' => '14" Full HD (1920 x 1080) LED display',
                'description' => '
                    14" Full HD (1920 x 1080) LED display

                    Intel® Pentium® Silver N5030 Processor (1.1 - 3.1 GHz)
                    
                    256GB SSD storage
                    
                    8GB RAM
                    
                    Intel® UHD Graphics 605
                    
                    1 x HDMI port
                    
                    1 x USB-A 2.0 port
                    
                    1 x USB-A 3.2 port
                    
                    1 x USB-C 3.2 port
                    
                    Webcam
                    
                    Wi-Fi ac
                    
                    Bluetooth v4.1
                    
                    Windows 11 operating system
                ',
                'price' => 769,
                'featured' => true,
                'category_id' => 1
            ],
            [
                'name' => 'ASUAsus VivoBook',
                'image' => 'asus_vivobook.png',
                'slug' => 'asuasus_vivobook',
                'details' => 'F15 15.6" Full HD Laptop (512GB) [Intel i7]',
                'description' => '
                    15.6" Full HD (1920 x 1080) 16:9 display

                    Intel® Core™ i7-1165G7 processor (2.8 - 4.7GHz)
                    
                    512GB SSD storage
                    
                    8GB RAM
                    
                    Intel® UHD Graphics
                    
                    1 x HDMI port
                    
                    2 x USB-A 2.0 ports
                    
                    1 x USB-A 3.2 port
                    
                    2 x USB-C 3.2 port
                    
                    Webcam
                    
                    Bluetooth v4.1
                    
                    Wi-Fi ac
                    
                    Windows 10 Home operating system
                ',
                'price' => 999,
                'featured' => false,
                'category_id' => 1
            ],
            [
                'name' => 'Dell Inspiron',
                'image' => 'dell_inspiron.png',
                'slug' => 'dell_inspiron',
                'details' => '5410 14" Full HD 2-in-1 Laptop (256GB) [Intel i5]',
                'description' => '
                    14.0-inch FHD (1920 x 1080) Truelife Touch Narrow Border WVA Display 

                    11th Generation Intel® Core™ i5-1155G7 Processor (8MB Cache, up to 4.5 GHz)
                    
                    256GB SSD storage
                    
                    8GB RAM
                    
                    Intel® Iris® Xe Graphics with shared graphics memory
                    
                    1 x HDMI port
                    
                    2 x USB-A 3.2 ports
                    
                    1 x USB-C port
                    
                    Micro SD reader
                    
                    Webcam
                    
                    Bluetooth v5.1
                    
                    Wi-Fi 6 (802.11 ax)
                    
                    Windows 11 operating system
                ',
                'price' => 999,
                'featured' => false,
                'category_id' => 1
            ],
            [
                'name' => 'Asus ROG Strix',
                'image' => 'asus_rog_strix.png',
                'slug' => 'asus_rog_strix',
                'details' => 'G10DK Gaming Desktop (Ryzen 7) [RTX 3060]',
                'description' => '
                    AMD Ryzen™ 7-3700X Processor (3.6 - 4.4GHz)

                    NVIDIA® GeForce® RTX3060 graphics
                    
                    512GB SSD storage
                    
                    16GB RAM
                    
                    1 x HDMI port
                    
                    6 x USB-A 3.1 ports
                    
                    2 x USB-A 3.2 ports
                    
                    Bluetooth v5.0
                    
                    Wi-Fi 5 (802.11 ac)
                    
                    Windows 11 operating system
                ',
                'price' => 1999,
                'featured' => false,
                'category_id' => 4
            ],
            [
                'name' => 'Samsung Q80A',
                'image' => 'samsung_q80a.png',
                'slug' => 'samsung_q80a',
                'details' => '65" QLED 4K Smart TV [2021]',
                'description' => '
                    Direct Full Array - Our LED zone technology precisely adjusts brightness and black levels for bold contrast, depth and detail.
                    Quantum Dot - Unleash vivid colour with Quantum Dot & 200Hz Motion Rate.
                    Object Tracking Sound - Object Tracking Sound follows objects on screen thanks to additional In-built speakers delivering upfiring sound.
                ',
                'price' => 2955,
                'featured' => true,
                'category_id' => 5
            ],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
