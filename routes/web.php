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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'PagesController@index')->name('homepage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//route to view books
Route::get('/view-books', 'Admin\AdminController@viewBooks')->name('view-books');
//route to add book
Route::post('/add-book', 'Admin\AdminController@addBook')->name('add-book');
//update book
Route::post('/update-book', 'Admin\AdminController@updateBook')->name('update-book');
//get book information 
Route::get('/book/{book}', 'Admin\AdminController@getBook')->name('get.book');
//view orders on the systm
Route::get('/orders', 'Admin\AdminController@viewOrders')->name('orders');
//route for a user to view his orders 
Route::get('/my-orders', 'HomeController@viewOrders')->name('my-orders');
Route::get('/books', 'PagesController@books')->name('books');
Route::get('/books/{book}', 'PagesController@viewBook')->name('book');
//route to store an order 
Route::post('/store-order','OrderController@storeOrder')->name('store-order'); 
//route to load order summary
Route::post('/order-summary', 'OrderController@orderSummary')->name('order-summary');
//confirm payment 
Route::post('/confirm-payment', 'OrderController@verifyTransaction')->name('confirm-payment');
//create virtual card 
Route::post('/create-card', 'VirtualCardsController@createCard')->name('create-card');
Route::get('/create-new-card', 'VirtualCardsController@createNewCard')->name('create-new-card');
Route::get('/cards', 'VirtualCardsController@viewCards')->name('cards');
//route to fund card
Route::post('/fund-card', 'VirtualCardsController@fundVirtualCard')->name('fund-card');
//route to view a card
Route::get('/cards/{id}', 'VirtualCardsController@getVirtualCard')->name('get.card');
//route to terminate a card 
Route::get('/terminate-card/{card}', 'VirtualCardsController@terminateCard')->name('terminate.card');
//route to block card
Route::get('/block-card/{card}', 'VirtualCardsController@blockCard')->name('block.card');
//route to unblock card 
Route::get('/unbloack-card/{card}', 'VirtualCardsController@unblockCard')->name('unblock.card');
//withdraw from card 
Route::post('/withdraw', 'VirtualCardsController@withdrawFromCard')->name('withdraw');
//get card transactions
Route::post('/view-transactions', 'VirtualCardsController@getCardTransactions')->name('view-transactions');
//route to sync cards
Route::get('/sync-cards', 'VirtualCardsController@syncCards')->name('sync-cards');
//route to confirm order
Route::get('/confirm-order/{order}', 'Admin\AdminController@confirmOrder')->name('confirm.order');
Route::get('/disable-order/{order}', 'Admin\AdminController@disableConfirmation')->name('disable.confirmation');
//flutterwabe webhook
Route::get('/flutterwave-hook', 'RaveWebHookController@index')->name('flutterwave-hook');
//route to change admin status
Route::post('/switch-admin-status', 'Admin\AdminController@switchAdminLevel')->name('switch-admin-status');
//route to delete user
Route::delete('/delete-user/{user}', 'VirtualCardsController@deleteUser')->name('delete.user');
//view users 
Route::get('/view-users', 'Admin\AdminController@viewUsers')->name('view-users');