<?php

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

Route::get('/register', function (){
    return redirect('/');
});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');

Route::post('/upload', 'CloudController@upload')->name('cloud.upload');
Route::post('/update/{filename}', 'CloudController@update')->name('cloud.update');

route::get('/delete/{fileName}', 'CloudController@delete')->name('cloud.delete');
route::get('/download/{fileId}', 'CloudController@downloadFile')->name('cloud.downloadFile');
route::get('/viewFiles', 'CloudController@viewFiles')->name('cloud.viewFiles');

route::post('/addUser', 'CloudController@addUser')->name('cloud.addUser');