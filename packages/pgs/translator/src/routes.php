<?php
use Pgs\Translator\TranslatorController;    

Route::middleware(['web', 'auth', 'IsAdmin'])->namespace('Pgs\Translator')->prefix(Config::get('app.admin_prefix'))->group(function () {	
	Route::controller(TranslatorController::class)->prefix('translator')->group(function () {	
		Route::match(array('GET'), '/', 'index')->name('translate_index');
		Route::match(array('POST', 'GET'), '/create', 'create')->name('create_translation');
		Route::match(array('GET'), '/update', 'update')->name('update_translation');
		Route::match(array('GET'), '/delete/{id}', 'delete')->name('delete_translation'); 
		Route::match(array('GET'), '/delete-lang/{id}', 'deleteLang')->name('delete_lang'); 
		Route::match(array('GET'), '/export-translations', 'exportTranslations')->name('export-translations');
		Route::match(array('GET', 'POST'), '/import-translations', 'importTranslations')->name('import-translations');
		Route::match(array('GET', 'POST'), '/add-language', 'addLanguage')->name('add-language');

	});
});