<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pgs\Translator\TranslatorModel;
class UpdateTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-translation {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $message = $this->argument('message');
        $default = ucfirst(str_replace('_', ' ', $message)); 
        $trans['en'] = [
                    'key' => $message,
                    'text' => $default,
                    'type' => 'messages',
              ];
        $trans['ar'] = [
                    'key' => $message,
                    'text' => $default,
                    'type' => 'messages',
              ];
        foreach($trans as  $locale=>$inputs){
            $data['locale'] = $locale;
            $data['group'] = $inputs['type'];
            $data['key'] = $inputs['key'];
            $data['value'] = $inputs['text'];
            
            try {
                $translation=TranslatorModel::where('locale',$locale)
                                ->where('group',$inputs['type'])
                                ->where('key',$inputs['key'])->first();
                if(empty($translation)){
                    $translation=TranslatorModel::Create($data);
                    $userMessage .= 'Translation Created for ' . $locale . ' The Text is : ' . $langtext . ', ';
                    \Artisan::call('translations:export {group}', ['group'=>'messages']);
                }
                
            } catch (\Exception $e) {
               //
            }
        }
        
       
    }
}
