<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CustomPostController;
use App\Http\Controllers\Admin\DataImportController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MailTemplateController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PostCollectionController;
use App\Http\Controllers\Admin\PostMediaController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebInstaller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
|----------------------------------------------------------------------------
| Back-end Routes
|----------------------------------------------------------------------------
 */
Route::controller(LoginController::class)->middleware(['IsInstallationComplete'])->prefix(Config::get('app.admin_prefix'))->group(function () {
    Route::match(array('GET', 'POST'), '/', 'index');
    Route::match(array('GET', 'POST'), '/login', 'index')->name('login');
    Route::match(['GET', 'POST'], '/reset-password-admin', 'resetPassword')->name('reset-password-admin');
    Route::get('/language/{lang}', 'setlanguage')->name('admin_language_switcher');
});

Route::middleware(['auth', 'IsAdmin', 'XSS', 'AdminLanguageSwitcher', 'IsInstallationComplete'])->prefix(Config::get('app.admin_prefix'))->group(function () {
    Route::match(array('GET', 'POST'), '/change-password-admin', [UsersController::class, 'changePassword'])->name('admin_change_password');
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::middleware(['ForcePasswordChange'])->group(function () {
        Route::get('dashboard', [UsersController::class, 'dashboard'])->name('admin_dashboard');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

        Route::controller(AuditController::class)->group(function () {
            Route::match(array('GET'), '/audit-logs', 'index')->name('admin_audit_logs');
            Route::match(array('GET'), '/audit-logs/{id}', 'details')->name('audit-logs-details');
        });

        /*Users*/

        Route::controller(UsersController::class)->prefix('users')->group(function () {
            Route::get('/', 'index')->name('users');
            Route::match(array('GET', 'POST'), '/create', 'create')->name('user-create');
            Route::match(array('GET', 'POST'), '/edit/{id}', 'edit')->name('user-edit');
            Route::get('/delete/{id}', 'delete')->name('user-delete');
            Route::get('/changestatus/{id}/{status}', 'changestatus')->name('user-change-status');
            Route::get('/approved-status/{id}/{status}', 'approved_status')->name('user-approved-status');
            Route::match(array('GET', 'POST'), '/reset-password/{id}', 'resetPassword')->name('reset_user_password_admin');
        });
        /*User Permissions*/
        Route::controller(PermissionsController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'permissions', 'index')->name('permission_list');
            Route::match(array('GET', 'POST'), 'permissions/create', 'create')->name('permission_create');
            Route::match(array('GET', 'POST'), 'permissions/edit/{id}', 'edit')->name('permission_edit');
            Route::match(array('GET', 'POST'), 'permissions/delete/{id}', 'delete')->name('permission_delete');
            Route::match(array('GET', 'POST'), 'generate-permissions', 'generate_permissions')->name('generate-permissions');
        });

        /*Roles*/
        Route::controller(RolesController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'roles', 'index')->name('roles-index');
            Route::match(array('GET', 'POST'), 'roles/create', 'create')->name('roles-create');
            Route::match(array('GET', 'POST'), 'roles/edit/{id}', 'edit')->name('roles-edit');
            Route::match(array('GET', 'POST'), 'roles/delete/{id}', 'delete')->name('roles-delete');
        });

        /* Mail Templates */
        Route::controller(MailTemplateController::class)->prefix('mail-templates')->group(function () {
            Route::match(array('GET', 'POST'), '/', 'index')->name('admin_mailtemplate');
            Route::match(array('GET', 'POST'), '/create', 'create')->name('admin_mailtemplate_create');
            Route::match(array('GET', 'POST'), '/edit/{id}', 'update')->name('admin_mailtemplate_update');
            Route::get('/delete/{id}', 'delete')->name('admin_mailtemplate_delete');
            Route::match(array('GET', 'POST'), '/test-mail-template/{id}', 'testMailTemplate')->name('admin_mailtemplate_test_email');
        });
        Route::controller(MenuController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'post/menu', 'index')->name('menu_index');
            Route::match(array('GET', 'POST'), 'post/menu/add', 'create')->name('menu_create');
            Route::match(array('GET', 'POST'), 'post/menu/edit/{id}', 'edit')->name('menu_edit');
            Route::match(array('GET', 'POST'), 'post/menu/changestatus/{id}/{status}', 'changestatus')->name('menu_change_status');
            Route::match(array('GET', 'POST'), 'post/menu/delete/{id}', 'delete')->name('menu_delete');
            Route::match(array('GET', 'POST'), '/menu_manager/sort_menu', 'sort_menu')->name('sort_menu');
        });

        Route::controller(PostCollectionController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'post/{slug}', 'index')->name('post_index');
            Route::match(array('GET', 'POST'), 'post/{slug}/add', 'create')->name('post_create');
            Route::match(array('GET', 'POST'), 'post/{slug}/edit/{id}', 'edit')->name('post_edit');
            Route::match(array('GET', 'POST'), 'post/{slug}/changestatus/{id}/{status}', 'changestatus')->name('post_change_status');
            Route::match(array('GET', 'POST'), 'post/{slug}/delete/{id}', 'delete')->name('post_delete');
            Route::match(array('GET', 'POST'), 'post/{slug}/remove_meta_attachment/{field}/{about_id}', 'removeMetaAttachment');
            
            Route::match(array('GET', 'POST'), 'admin_filedelete/{fileName}', 'general_filedelete');
            Route::match(array('GET', 'POST'), 'admin_filedownload/{fileName}', 'general_filedownload');
        });
        Route::controller(PostCollectionController::class)->middleware(['optimizeImages'])->group(function () {
            Route::match(array('GET', 'POST'), 'admin_fileupload', 'fileupload');
        });
        
        Route::controller(PostMediaController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'post_media/save_youtube_video', 'save_youtube_video')->name('save_youtube_video');
            Route::match(array('GET', 'POST'), 'post_media/update_priority/', 'update_priority')->name('post_media_update_priority');
            Route::match(array('GET', 'POST'), 'post_media/update_text/', 'update_text')->name('post_media_update_text');
            Route::match(array('GET', 'POST'), 'post_media/{slug}', 'index')->name('post_media_index');
            Route::match(array('GET', 'POST'), 'post_media/{slug}/add', 'create')->name('post_media_create');
            Route::match(array('GET', 'POST'), 'post_media_download/{id}', 'post_media_download');
            Route::match(array('GET', 'POST'), 'post_media/delete/{id}', 'delete')->name('post_media_delete');
            Route::match(array('GET', 'POST'), 'download-post-file/{filename}', 'download_file_from_file_name')->name('download_post_file_by_name');
        });

        Route::controller(PostMediaController::class)->middleware(['optimizeImages'])->group(function () {
            Route::match(array('GET', 'POST'), 'post_media/{slug}/add', 'create')->name('post_media_create');
        });
        // this route for create custom post type folder strecture remove this route and controller when pushing to production
        Route::controller(CustomPostController::class)->group(function () {
            Route::match(array('GET', 'POST'), 'add-post-type', 'add')->name('add-post-type');
            Route::match(array('GET'), 'tools', 'tools')->name('tools');
        });

        Route::controller(DataImportController::class)->group(function () {
            Route::match(array('GET', 'POST'), '/import-posts', 'importPostData')->name('import-posts');
            Route::match(array('GET', 'POST'), '/export-posts', 'exportPostData')->name('export-posts');
            Route::match(['GET'], '/optimize-images', 'optimizeImages')->name('optimize-images');
            Route::match(array('GET', 'POST'), '/import-data', 'general_file_import')->name('import-data');
            Route::match(array('GET', 'POST'), '/export-data', 'general_file_export')->name('export-data');
        });
    });







});

Route::controller(WebInstaller::class)->prefix('web-installer')->group(function () {

    Route::match(array('GET'), '/', 'index')->name('web-installer');
    Route::match(array('GET'), '/check-prerequisites', 'checkPrerequisites')->name('check-prerequisites');
    Route::match(array('POST'), '/check-database', 'checkDatabaseSettings')->name('check-database');
    Route::match(array('POST'), '/check-mail', 'checkMailSettings')->name('check-mail');
    Route::match(array('POST'), '/check-admin', 'checkAdminSettings')->name('check-admin');
    Route::match(array('POST'), '/run-migrations', 'runMigrations')->name('run-migrations');
    Route::match(array('POST'), '/create-admin', 'createAdmin')->name('create-admin');
    Route::match(array('POST'), '/create-env', 'createEnv')->name('create-env');
    Route::match(array('POST'), '/link-storage', 'linkStorage')->name('link-storage');
    Route::match(array('POST'), '/finalize-installation', 'finalizeInstallation')->name('finalize-installation');
    Route::match(array('GET'), '/get-csrf', 'getCSRF')->name('get-csrf');

});
Route::controller(HomeController::class)->middleware(['IsInstallationComplete'])->group(function () {
    Route::get('/language/{lang}', 'setlanguage')->name('set_language');
    Route::match(array('GET'), '/page-not-found', 'pageNotFound')->name('error404');
    Route::get('/', 'index')->name('home');
});
Route::fallback(function () {
	return redirect()->to(route('error404'));
});
