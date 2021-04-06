<?php

use App\Http\Controllers\User\ExtraController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\VideoController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MyTeamController;
use App\Http\Controllers\User\WithdrawController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/test', function () {
    return auth()->user()->incomeBalance->sum('amount');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // Video Controller
    Route::get('daily-work', [VideoController::class, 'index'])->name('daily.work');
    Route::get('add/watch/{slug}/{id}', [VideoController::class, 'addIncomeInUserAccount'])->name('add.watch');
    Route::get('watch/daily-work/{slug}', [VideoController::class, 'showAddIncomeVideo'])->name('watch.daily.work');

    // Auth User Profile Define Here....
    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('update', [ProfileController::class, 'showUpdateProfileForm'])->name('update');
        Route::put('info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::get('change-password', [ProfileController::class, 'showChangePasswordForm'])->name('change.password');
        Route::put('password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::group(['as' => 'team.', 'prefix' => 'team'], function () {
        Route::get('tree-view', [MyTeamController::class, 'treeView'])->name('tree.view');
        Route::get('tree-view/{id}', [MyTeamController::class, 'treeViewById'])->name('tree.view.id');
        Route::get('list-view', [MyTeamController::class, 'listView'])->name('list.view');
        Route::get('profile/{id}', [MyTeamController::class, 'profile'])->name('profile');
    });
    
    Route::group(['prefix' => 'withdraw'], function () {
        Route::get('income/history', [WithdrawController::class, 'showIncomeHistory'])->name('income.history');
        Route::get('money/exchange/list', [WithdrawController::class, 'showMoneyExchangeList'])->name('money.exchange.list');
        Route::get('money/exchange', [WithdrawController::class, 'showMoneyExchangeForm'])->name('money.exchange');
        Route::post('money/exchange', [WithdrawController::class, 'moneyExchange'])->name('exchange');
        

        Route::get('shop/balance', [WithdrawController::class, 'shopBalance'])->name('shop.balance');
        Route::get('shop/balance/create', [WithdrawController::class, 'showShopBalanceForm'])->name('shop.balance.create');
        Route::post('shop/balance', [WithdrawController::class, 'storeShopBalance'])->name('shop.balance.store');
    });

    Route::group(['as' => 'connection.', 'prefix' => 'connection'], function() {
        Route::get('/contact', [ExtraController::class, 'showContactForm'])->name('contact');
        Route::post('/contact', [ExtraController::class, 'storeContact'])->name('store.contact');
        
        Route::get('/live-chat', [ExtraController::class, 'showLiveChatForm'])->name('live.chat');
        Route::get('/live-chat/new-sms/count', [ExtraController::class, 'countNewMessage'])->name('live.chat.new-sms.count');
        Route::get('/live-chat-list', [ExtraController::class, 'liveChatList'])->name('live.chat.list');
        Route::post('/live-chat', [ExtraController::class, 'storeLiveChatForm'])->name('store.chat');
        // Route::post('/contact', [ExtraController::class, 'storeContact'])->name('store.contact');
    });
    
    Route::resource('withdraw', WithdrawController::class);
    
    Route::get('add_referrer', [ExtraController::class, 'showReferrerForm'])->name('show.referrer.form');
    Route::post('add_referrer', [ExtraController::class, 'storeReferrer'])->name('store.referrer');

    // View Dynamic Created Page
    
    Route::get('/{slug}', [ExtraController::class, 'viewPage'])->name('view.page');

    
});







