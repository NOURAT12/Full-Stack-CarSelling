<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            Setting::create([
                'website_name' => 'Tiger',
                'website_image' => json_encode(["images\/settings\/68090f1102226.png","images\/settings\/68090f110263a.jpg","images\/settings\/68090f1102a49.jpg"]),
                'logo' => 'images/settings/68090f1102da1.png',
                'facebook' => 'https://www.facebook.com/profile.php?id=100012795527108',
                'instgram' => 'https://www.facebook.com/profile.php?id=100012795527108',
                'whatsapp' => '0997529133',
                'phone' => '76273822',
                'mobile' => '0997529133',
                'titles' => json_encode(["Good Car","Greate Car","Super Car"]),
                'images' => json_encode(["images\/settings\/68090f11014bf.png","images\/settings\/68090f1101983.jpg","images\/settings\/68090f1101dd2.jpg"]),
            ]);
        }
    }
}
