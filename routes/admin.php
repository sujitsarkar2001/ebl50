<?php

use App\Http\Controllers\Admin\CorrectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\MyTeamController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TableDataController;
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
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    
    
    Route::get('notice/data', [TableDataController::class, 'getNoticeData'])->name('notice.data');
    Route::get('staff/data', [TableDataController::class, 'getStaffData'])->name('staff.data');
    Route::get('page/data', [TableDataController::class, 'getPageData'])->name('page.data');
    Route::get('user/{status}/data', [TableDataController::class, 'getUserData'])->name('user.data');
    Route::get('video/data', [TableDataController::class, 'getVideoData'])->name('video.data');
    Route::get('withdraw/data', [TableDataController::class, 'getWithdrawData'])->name('withdraw.data');
    Route::get('money/exchange/data', [TableDataController::class, 'getMoneyExchangeData'])->name('money.exchange.data');
    Route::get('sponsor/income/data', [TableDataController::class, 'getSponsorIncomeData'])->name('sponsor.income.data');
    Route::get('generation/income/data', [TableDataController::class, 'getGenerationIncomeData'])->name('generation.income.data');
    Route::get('level/income/data', [TableDataController::class, 'getLevelIncomeData'])->name('level.income.data');
    Route::get('site/income/data', [TableDataController::class, 'getSiteIncomeData'])->name('site.income.data');
    Route::get('share/income/data', [TableDataController::class, 'getShareIncomeData'])->name('share.income.data');
    Route::get('daily/income/data', [TableDataController::class, 'getDailyIncomeData'])->name('daily.income.data');
    Route::get('shop/balance/data', [TableDataController::class, 'getShopBalanceData'])->name('shop.balance.data');
    Route::get('income/balance/data', [TableDataController::class, 'getIncomeBalanceData'])->name('income.balance.data');
    Route::get('contact/data', [TableDataController::class, 'getContactData'])->name('contact.data');


    // Auth User Profile Define Here....
    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/get-info', [ProfileController::class, 'getInfo'])->name('get.info');
        Route::put('info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::put('password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::group(['as' => 'team.', 'prefix' => 'team'], function () {
        Route::get('tree-view', [MyTeamController::class, 'treeView'])->name('tree.view');
        Route::get('tree-view/{id}', [MyTeamController::class, 'treeViewById'])->name('tree.view.id');
        Route::get('list-view', [MyTeamController::class, 'listView'])->name('list.view');
        Route::get('profile/{id}', [MyTeamController::class, 'profile'])->name('profile');
    });
    
    // Application Setting Route Define Here....
    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    Route::put('setting', [SettingController::class, 'update'])->name('setting.update');
    Route::put('setting/logo', [SettingController::class, 'updateLogo'])->name('update.logo');
    
    // User Controller
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('new', [UserController::class, 'showNewUser'])->name('new');
        Route::get('blocked', [UserController::class, 'showBlockedUser'])->name('blocked');
        Route::get('approved', [UserController::class, 'showApprovedUser'])->name('approve');
        Route::get('{id}/approved', [UserController::class, 'approved'])->name('approved');
        Route::get('{id}/status', [UserController::class, 'status'])->name('status');
    });

    Route::group(['as' => 'withdraw.', 'prefix' => 'withdraw'], function () {
        Route::get('history', [WithdrawController::class, 'index'])->name('index');
        Route::get('{id}', [WithdrawController::class, 'show'])->name('show');
        Route::get('approved/{id}', [WithdrawController::class, 'approved'])->name('approved');
        Route::put('{id}', [WithdrawController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [WithdrawController::class, 'destroy'])->name('destroy');
        
        Route::get('income/history', [WithdrawController::class, 'showIncomeHistory'])->name('income.history');
        Route::get('income/search', [WithdrawController::class, 'searchIncomeHistory'])->name('income.search');
        
        Route::get('money/exchange', [WithdrawController::class, 'showMoneyExchangeList'])->name('money.exchange');
        Route::delete('money/exchange/{id}', [WithdrawController::class, 'destroyMoneyExchange'])->name('money.exchange.destroy');
        
        Route::get('shop/balance', [WithdrawController::class, 'shopBalance'])->name('shop.balance');
        Route::post('shop/balance', [WithdrawController::class, 'storeShopBalance'])->name('shop.balance.store');
        
        Route::get('income/balance', [WithdrawController::class, 'incomeBalance'])->name('income.balance');
        Route::get('income/balance/info', [WithdrawController::class, 'incomeBalanceInfo'])->name('income.balance.info');
        Route::get('income/balance/{id}', [WithdrawController::class, 'showIncomeBalance'])->name('show.income.balance');
        Route::post('income/balance', [WithdrawController::class, 'storeIncomeBalance'])->name('income.balance.store');
    });

    Route::group(['as' => 'connection.', 'prefix' => 'connection'], function() {
        Route::get('/contact', [CorrectionController::class, 'contact'])->name('contact');
        Route::delete('/contact/{id}', [CorrectionController::class, 'destroyContact'])->name('destroy.contact');
        Route::get('/contact/{id}', [CorrectionController::class, 'showContact'])->name('show.contact');
        Route::post('/reply/contact/{id}', [CorrectionController::class, 'replyContact'])->name('reply.contact');

        Route::get('/live-chat', [CorrectionController::class, 'showLiveChatForm'])->name('live.chat');
        Route::get('/live-chat/new-sms/count', [CorrectionController::class, 'countNewMessage'])->name('live.chat.new-sms.count');
        Route::get('/live-chat-user-list', [CorrectionController::class, 'liveChatUserList'])->name('live.chat.user.list');
        Route::get('/live-chat-list', [CorrectionController::class, 'liveChatList'])->name('live.chat.list');
        Route::get('/live-chat-list/{id}', [CorrectionController::class, 'liveChatListById']);
        Route::post('/live-chat', [CorrectionController::class, 'storeLiveChatForm'])->name('store.chat');
        Route::get('/live-chat/status/{id}', [CorrectionController::class, 'updateStatus']);
    });

    Route::get('notice/{id}/status', [NoticeController::class, 'status'])->name('notice.status');
    Route::get('page/{id}/status', [PageController::class, 'status'])->name('page.status');

    Route::resource('staff', StaffController::class);
    Route::resource('user', UserController::class);
    Route::resource('page', PageController::class);
    Route::resource('video', VideoController::class);
    Route::resource('notice', NoticeController::class);
    Route::resource('service', ServiceController::class);
    

    // View Dynamic Created Page
    Route::get('level', [ExtraController::class, 'showLevel'])->name('level');
    Route::get('level/{slug}', [ExtraController::class, 'showLevelUser'])->name('level.user');
    Route::get('/{slug}', [ExtraController::class, 'viewPage'])->name('view.page');
});
