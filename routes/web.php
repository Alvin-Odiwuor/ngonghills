<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');

    Route::resource('loyalty-accounts', 'LoyaltyAccountController');
    Route::resource('point-transactions', 'PointTransactionController');
    Route::resource('rewards', 'RewardController');
    Route::resource('redemptions', 'RedemptionController');
    Route::resource('ingredients', 'IngredientController');
    Route::resource('ingredient-purchases', 'IngredientPurchaseController');
    Route::resource('recipes', 'RecipeController');
    Route::resource('recipe-ingredients', 'RecipeIngredientController');
    Route::resource('production-runs', 'ProductionRunController');
});

