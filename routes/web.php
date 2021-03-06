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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


//bolor url-neri hamar validacia grac e App/Providers/routeServiceProvider/boot file-i mej



Route::resource('/', 'IndexController', [
                                        'only' => ['index'],
                                        'names' => [
                                            'index' => 'home'
                                        ]
                                        ]);

Route::resource('portfolios', 'PortfolioController', [
                                                        'parameters' => [
                                                            'portfolios' => 'alias',
                                                        ],
                                                    ]);

Route::resource('articles', 'ArticlesController',[
                                                    'parameters' =>[
                                                        'articles' => 'alias'
                                                    ],
                                                ]);

Route::get('articles/cat/{cat_alias?}',['uses' => 'ArticlesController@index', 'as' => 'articlesCat'])->where('cat_alias', '[\w-]+');//urli-i validacia

Route::resource('comment', 'CommentController', ['only' => ['store']]);

Route::match(['get', 'post'], '/contacts', ['uses' => 'ContactsController@index', 'as' => 'contacts']);


Route::get('login', 'Auth\LoginController@showLoginForm');

Route::post('log_in', 'Auth\LoginController@authenticate');

Route::get('logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
