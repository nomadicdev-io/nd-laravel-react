<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mail_templates')->delete();
        
        \DB::table('mail_templates')->insert(array (
            0 => 
            array (
                'mt_created_at' => '2021-12-16 13:10:20',
                'mt_id' => 1,
                'mt_slug' => 'thank-you-registration',
                'mt_subject' => 'Thank you - Registration',
                'mt_subject_arabic' => 'Thank you - Registration',
                'mt_template' => '<h4>Dear {contact_name},</h4><p>Thank you for contacting us! Our team will get back to you soon!</p>',
                'mt_template_arabic' => '<h4>زيزي/عزيزتي {contact_name}،</h4><p>كراً لتواصلكم مع . سيتم الرد عليكم قريباً.</p>',
                'mt_title' => 'Thank you - Registration',
                'mt_updated_at' => '2021-12-16 13:10:20',
            ),
            1 => 
            array (
                'mt_created_at' => '2021-12-23 12:39:30',
                'mt_id' => 2,
                'mt_slug' => 'registration-approved',
                'mt_subject' => 'Registration Approved',
                'mt_subject_arabic' => 'Registration Approved',
                'mt_template' => '<h4>Dear {contact_name},</h4><p>Application Approved.</p>',
                'mt_template_arabic' => '<h4>Dear {contact_name},</h4><p>Application Approved.</p>',
                'mt_title' => 'Registration Approved',
                'mt_updated_at' => '2021-12-23 12:39:30',
            ),
        ));
        
        
    }
}