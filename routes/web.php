<?php

use App\Http\Controllers\User\NoticeController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\ExtraController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\GeneralLedgerController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\JoinRefererController;
use App\Http\Controllers\User\DailyWorkController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MyTeamController;
use App\Http\Controllers\User\ShopController;
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

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/', HomeController::class)->name('dashboard');
    Route::get('/home', DashboardController::class)->name('home');

    // Video Controller
    Route::get('daily-work', [DailyWorkController::class, 'index'])->name('daily.work');
    Route::get('add/watch/{slug}/{id}', [DailyWorkController::class, 'addIncomeInUserAccount'])->name('add.watch');
    Route::get('watch/daily-work/{slug}/{id}', [DailyWorkController::class, 'showAddIncomeVideo'])->name('watch.daily.work');

    // Auth User Profile Define Here....
    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('update', [ProfileController::class, 'showUpdateProfileForm'])->name('update');
        Route::put('info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::get('change-password', [ProfileController::class, 'showChangePasswordForm'])->name('change.password');
        Route::put('password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::group(['as' => 'team.', 'prefix' => 'team'], function () {
        Route::get('/', [MyTeamController::class, 'index'])->name('index');
        Route::get('tree-view', [MyTeamController::class, 'treeView'])->name('tree.view');
        Route::get('tree-view/{username}', [MyTeamController::class, 'treeViewById'])->name('tree.view.username');
        Route::get('list-view', [MyTeamController::class, 'listView'])->name('list.view');
        Route::get('profile/{username}', [MyTeamController::class, 'profile'])->name('profile');
    });

    Route::group(['prefix' => 'withdraw'], function () {
        Route::get('money/exchange', [WithdrawController::class, 'showMoneyExchangeForm'])->name('money.exchange');
        Route::post('money/exchange', [WithdrawController::class, 'moneyExchange'])->name('exchange');

    });

    Route::group(['as' => 'connection.', 'prefix' => 'connection'], function() {
        Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact');
        Route::post('/contact', [ContactController::class, 'storeContact'])->name('store.contact');

        Route::get('/live-chat', [ContactController::class, 'showLiveChatForm'])->name('live.chat');
        Route::get('/live-chat/new-sms/count', [ContactController::class, 'countNewMessage'])->name('live.chat.new-sms.count');
        Route::get('/live-chat-list', [ContactController::class, 'liveChatList'])->name('live.chat.list');
        Route::post('/live-chat', [ContactController::class, 'storeLiveChatForm'])->name('store.chat');
    });


    Route::get('general-ledger', [GeneralLedgerController::class, 'index'])->name('general-ledger');
    Route::get('sponsor-income', [GeneralLedgerController::class, 'sponsorIncome'])->name('sponsor-income');
    Route::get('generation-income', [GeneralLedgerController::class, 'generationIncome'])->name('generation-income');
    Route::get('daily-income', [GeneralLedgerController::class, 'dailyIncome'])->name('daily-income');
    Route::get('level-income', [GeneralLedgerController::class, 'levelIncome'])->name('level-income');

    Route::get('withdraw-expense', [GeneralLedgerController::class, 'withdrawExpense'])->name('withdraw-expense');
    Route::get('exchange-expense', [GeneralLedgerController::class, 'exchangeExpense'])->name('exchange-expense');


    Route::get('send/shop/balance', [ShopController::class, 'sendShopBalanceForm'])->name('send.shop.balance');
    Route::get('shop/balance/history', [ShopController::class, 'history'])->name('shop.balance.history');


    Route::get('add/fund', [GeneralLedgerController::class, 'showAddFundForm'])->name('add.fund');
    Route::post('add/fund', [GeneralLedgerController::class, 'storeFund'])->name('store.fund');
    Route::get('fund', [GeneralLedgerController::class, 'showFundHistory'])->name('fund.history');

    Route::group(['as' => 'shop.', 'prefix' => 'shop'], function() {
        Route::get('company-transfer', [ShopController::class, 'companyTransfer'])->name('company-transfer');
        Route::get('member-transfer', [ShopController::class, 'memberTransfer'])->name('member-transfer');
        Route::get('transfer', [ShopController::class, 'transfer'])->name('transfer');
    });

    Route::get('join-referrer', [JoinRefererController::class, 'index'])->name('join.referrer');
    Route::post('join-referrer', [JoinRefererController::class, 'store'])->name('store.referrer');

    // Show notice
    Route::get('/notice', [NoticeController::class, 'index'])->name('notice');
    Route::get('/notice/{slug}', [NoticeController::class, 'details'])->name('notice.details');


    Route::resource('withdraw', WithdrawController::class)->only('index', 'create', 'store');


    // View Dynamic Created Page

    Route::get('level', [ExtraController::class, 'showLevel'])->name('level');
    Route::get('level/{slug}', [ExtraController::class, 'showLevelUser'])->name('level.user');
    Route::get('/{slug}', [ExtraController::class, 'viewPage'])->name('view.page');

});







