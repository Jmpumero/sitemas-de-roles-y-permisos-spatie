<?php
use App\User;
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
    //$users=User::all();
    return view('welcome');
});

//Route::resource('users','UserController');

//Route::delete('users/{users}', 'UsersController@destroy')->name('user.destroy');

Route::resource('users','UserController');
//Route::get('users', 'UserController@index')->name('users.index');
Route::delete('users/destroy/{id}', 'UserController@destroy');
Route::get('users/{id}/edit/','UserController@edit');
Route::post('users/update', 'UserController@update')->name('users.update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

 //{role} no es necesario tambien se le puede llamar desde el controlador haciendo uso de $user=Auth::user(); y de alli pedir el rol
Route::middleware(['auth'])->group(function () {

    Route::post('productos/store', 'ProductoController@store')->name('productos.store')
                                                        ->middleware('permission:productos.create');

    Route::get('productos', 'ProductoController@index')->name('productos.index')
                                                        ->middleware('permission:productos.index');

    Route::get('productos/create', 'ProductoController@create')->name('productos.create')
                                                        ->middleware('permission:productos.create');

    Route::put('productos/update', 'ProductoController@update')->name('productos.update')
                                                        ->middleware('permission:productos.edit');

    Route::get('productos/{role}', 'ProductoController@show')->name('productos.show')
                                                        ->middleware('permission:productos.show');

    Route::get('productos/eliminar/{id}', 'ProductoController@destroy')->name('productos.destroy')
                                                        ->middleware('permission:productos.destroy');

    Route::get('productos/{role}/edit', 'ProductoController@edit')->name('productos.edit')
                                                        ->middleware('permission:productos.edit');

    //Route::post('users/update', 'UserController@update')->name('productos.update');
});
