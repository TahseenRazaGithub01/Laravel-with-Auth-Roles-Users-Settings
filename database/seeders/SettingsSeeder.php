<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            [
                'contact_number'=>'+923003111117',
                'contact_email'=>'contact@website.com',
                'contact_whatsapp'=> '+923003111117',
                'footer_text'=> 'This is footer dummy text @ 2022-2023'
            ],
            
            
        ];
  
        foreach ($setting as $key => $value) {
            Setting::create($value);
        }
    }
}
