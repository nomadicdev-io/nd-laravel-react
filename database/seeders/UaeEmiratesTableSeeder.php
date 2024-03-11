<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UaeEmiratesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('uae_emirates')->delete();
        
        \DB::table('uae_emirates')->insert(array (
            0 => 
            array (
                'uae_id' => 1,
                'uae_state_name' => 'Abu Dhabi',
                'uae_state_name_arabic' => 'أبوظبي',
            ),
            1 => 
            array (
                'uae_id' => 2,
                'uae_state_name' => 'Dubai',
                'uae_state_name_arabic' => 'دبي',
            ),
            2 => 
            array (
                'uae_id' => 3,
                'uae_state_name' => 'Sharjah',
                'uae_state_name_arabic' => 'الشارقة ',
            ),
            3 => 
            array (
                'uae_id' => 4,
                'uae_state_name' => 'Ajman',
                'uae_state_name_arabic' => 'عجمان ',
            ),
            4 => 
            array (
                'uae_id' => 5,
                'uae_state_name' => 'Umm Al Quwain',
                'uae_state_name_arabic' => 'أم القيوين',
            ),
            5 => 
            array (
                'uae_id' => 6,
                'uae_state_name' => 'Ras Al Khaimah',
                'uae_state_name_arabic' => 'رأس الخيمة',
            ),
            6 => 
            array (
                'uae_id' => 7,
                'uae_state_name' => 'Fujairah',
                'uae_state_name_arabic' => 'الفجيرة ',
            ),
        ));
        
        
    }
}