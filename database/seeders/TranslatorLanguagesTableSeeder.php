<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslatorLanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('translator_languages')->delete();
        
        \DB::table('translator_languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'locale' => 'en',
                'name' => 'English',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'locale' => 'ar',
                'name' => 'Arabic',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}