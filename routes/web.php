<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', 'Admin\AdminController@index')->name('admin.index');
    Route::resource('admin/products', 'Admin\ProductController')->only([
        'create', 'store', 'update', 'destroy'
    ]);
    Route::get('/user/catalog', 'User\CatalogController@index')->name('user.catalog.index');
    Route::get('/user/invoice', 'User\InvoiceController@index')->name('user.invoice.index');
});

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', 'AdminController@dashboard')->name('admin.dashboard');
Route::get('/user', 'UserController@dashboard')->name('user.dashboard');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/barang', 'BarangController@index')->name('admin.barang.index');
    Route::get('/admin/barang/create', 'BarangController@create')->name('admin.barang.create');
    Route::post('/admin/barang/store', 'BarangController@store')->name('admin.barang.store');
    Route::get('/admin/barang/{id}/edit', 'BarangController@edit')->name('admin.barang.edit');
    Route::put('/admin/barang/{id}/update', 'BarangController@update')->name('admin.barang.update');
    Route::delete('/admin/barang/{id}/delete', 'BarangController@destroy')->name('admin.barang.destroy');
});


