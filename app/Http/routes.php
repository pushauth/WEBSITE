<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'tester'], function () {

    Route::get('/nodejs', function () {
        return view('tester.nodejs');
    });

    Route::post('/cookie', ['uses'=>'TestController@showCookie'])->name('c');

    Route::get('/stripe', ['uses' => 'TestController@showStripe']);
    //Route::post('/stripe', ['uses' => 'TestController@storeStripe'])->name('stripe.store');

    Route::get('/guzzle', ['uses' => 'TestController@showGuzzle']);

    Route::get('/validator', ['uses' => 'TestController@showValidator']);

    Route::get('/pushauth', ['uses' => 'TestController@showPushAuth']);

    Route::get('/carbon', ['uses' => 'TestController@showCarbon']);

    Route::get('/hmac', ['uses' => 'TestController@showHmac']);

    Route::get('/redis', ['uses' => 'TestController@showRedis']);
    Route::get('/redis/store', ['uses' => 'TestController@showRedisStore']);

    Route::get('/model', ['uses' => 'TestController@showModel']);

    Route::get('/mailgun', ['uses' => 'TestController@showMailgun']);

    Route::get('/', ['uses' => 'TestController@index']);

    Route::get('/firebase', ['uses' => 'TestController@showFirebase']);

    Route::post('/http', ['uses' => 'TestController@indexHttp']);

    Route::post('/cpp', ['uses' => 'TestController@indexCpp']);

    Route::get('send/{id}', ['uses' => 'TestController@indexSend']);
    Route::get('encrypt', ['uses' => 'TestController@testEncrypt']);

    Route::get('push', ['uses' => 'TestController@showPush']);
});

/*Route::group(['domain' => 'www.pushauth.' . env('DOMAIN_LTD', 'io')], function () {
    return redirect();
}*/

Route::group(['domain' => 'www.pushauth.' . env('DOMAIN_LTD', 'io')], function () {
    Route::get('/', function() {
        return Redirect::to('https://pushauth.'. env('DOMAIN_LTD', 'io'));
    });
    //return Redirect::to('https://pushauth.'. env('DOMAIN_LTD', 'io'));
});


Route::group(['domain' => 'dashboard.pushauth.' . env('DOMAIN_LTD', 'io')], function () {
//Route::group(['prefix' => 'dashboard'], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::get('app/logo/{hash}', ['uses' => 'APIControllers\AppController@showLogo'])->name('app.logo.show');


        Route::get('/', ['uses' => 'Dashboard\DashboardController@index'])->name('dashboard');

        Route::get('/app', ['uses' => 'Dashboard\AppController@index'])->name('appList');

        Route::get('/app/add', ['uses' => 'Dashboard\AppController@create'])->name('appAdd');
        Route::get('/app/{hash}', ['uses' => 'Dashboard\AppController@show'])->name('app.show');

        Route::post('/app/{hash}/pushes', ['uses' => 'Dashboard\AppController@showPushesAjax'])->name('app.show.pushes.ajax');


        Route::get('/app/{hash}/pushes', ['uses' => 'Dashboard\AppController@showPushes'])->name('app.show.pushes');
        Route::get('/app/{hash}/devices', ['uses' => 'Dashboard\AppController@showDevices'])->name('app.show.devices');
        Route::post('/app/{hash}/devices', ['uses' => 'Dashboard\AppController@showDevicesAjax'])->name('app.show.devices.ajax');


        Route::get('/app/{hash}/clients', ['uses' => 'Dashboard\AppController@showClients'])->name('app.show.clients');
        Route::post('/app/{hash}/clients', ['uses' => 'Dashboard\AppController@showClientsAjax'])->name('app.show.clients.ajax');

        Route::get('/app/{hash}/routes', ['uses' => 'Dashboard\AppController@showRoutes'])->name('app.show.routes');
        Route::post('/app/{hash}/routes', ['uses' => 'Dashboard\AppController@showRoutesAjax'])->name('app.show.routes.ajax');

        Route::get('/app/{hash}/hooks', ['uses' => 'Dashboard\AppController@showHooks'])->name('app.show.hooks');
        Route::post('/app/{urlhash}/hooks/update', ['uses' => 'Dashboard\AppController@updateHooks'])->name('app.hooks.update');

        //Route::post('/app/{urlhash}/hooks/test', ['uses' => 'Dashboard\AppController@storeHooksTest'])->name('app.hooks.test');
        Route::get('/app/{hash}/settings', ['uses' => 'Dashboard\AppController@showSettings'])->name('app.show.settings');

        Route::patch('/app/store', ['uses' => 'Dashboard\AppController@store'])->name('appStore');

        //Route::get('/app/edit/{urlhash}', ['uses' => 'Dashboard\AppController@edit'])->name('app.Edit');
        Route::post('/app/edit/{urlhash}', ['uses' => 'Dashboard\AppController@update'])->name('app.update');

        Route::post('/app/keys', ['uses' => 'Dashboard\AppController@updateKeys'])->name('app.newKeys');

        Route::get('/app/delete/{urlhash}', ['uses' => 'Dashboard\AppController@destroy'])->name('app.delete');


        Route::get('/test/server', ['uses' => 'Dashboard\TestController@showServer'])->name('test.server');

        Route::post('/test/server/base64', ['uses' => 'Dashboard\TestController@showServerBase64'])->name('test.server.base64');
        Route::post('/test/server/hmac', ['uses' => 'Dashboard\TestController@showServerHMAC'])->name('test.server.hmac');

        Route::get('/test/{hash?}', ['uses' => 'Dashboard\TestController@index'])->name('testList');

        Route::post('/test/app', ['uses' => 'Dashboard\TestController@store'])->name('testApp');

        Route::post('/test/app/status', ['uses' => 'Dashboard\TestController@showStatus'])->name('testAppStatus');


        Route::get('/profile', ['uses' => 'Profile\ProfileController@index'])->name('profile');
        Route::post('/profile', ['uses' => 'Profile\ProfileController@update'])->name('profile.update');
        Route::post('/profile/delete', ['uses' => 'Profile\ProfileController@destroy'])->name('profile.delete');
        Route::post('/profile/update/image', ['uses' => 'Profile\ProfileController@updateImage'])->name('profile.updateImage');

        Route::get('/profile/image/{hash}', ['uses' => 'Profile\ProfileController@showUserImage'])->name('profile.showImage');


        Route::post('/profile/mail', ['uses' => 'Profile\ProfileController@updateMail'])->name('profile.update.mail');

        Route::get('/profile/security', ['uses' => 'Profile\ProfileController@showSecurity'])->name('profile.security');

        Route::post('/profile/password', ['uses' => 'Profile\ProfileController@updatePassword'])->name('profile.update.password');

        Route::get('/profile/billing', ['uses' => 'Profile\ProfileController@showBilling'])->name('profile.billing');
        Route::post('/profile/billing', ['uses' => 'Profile\ProfileController@storeBilling'])->name('profile.billing.save');
        Route::get('/profile/billing/card/delete/{hash}', ['uses' => 'Profile\ProfileController@destroyCard'])->name('billing.card.delete');

        Route::get('/profile/billing/charge', ['uses' => 'Profile\ProfileController@updateCharge'])->name('profile.billing.charge');
        Route::get('/profile/billing/cancel', ['uses' => 'Profile\ProfileController@updateCancel'])->name('profile.billing.cancel');
        //billing.card.delete
        //

        Route::get('/profile/price', ['uses' => 'Profile\ProfileController@showPrice'])->name('profile.price');

        Route::get('/profile/price/change/{id}', ['uses' => 'Profile\ProfileController@updatePrice'])->name('profile.price.update');

        Route::get('/profile/notify', ['uses' => 'Profile\ProfileController@showNotify'])->name('profile.notify');
        Route::get('/profile/notify/{hash}', ['uses' => 'Profile\ProfileController@showNotifyItem'])->name('profile.notify.show');


        Route::get('/support', ['uses' => 'Support\SupportController@index'])->name('support');

        Route::get('/support/requests', ['uses' => 'Support\SupportController@indexTicket'])->name('support.ticket.index');
        Route::get('/support/request/create', ['uses' => 'Support\SupportController@createTicket'])->name('support.ticket.create');
        Route::get('/support/request/{hash}', ['uses' => 'Support\SupportController@show'])->name('support.ticket.show');

        Route::get('/support/request/file/{hash}', ['uses' => 'Support\SupportController@showDownload'])->name('support.ticket.file.download');
        Route::get('/support/request/file/{hash}/image', ['uses' => 'Support\SupportController@showDownloadImage'])->name('support.ticket.file.download.image');

        Route::get('/support/request/{hash}/close', ['uses' => 'Support\SupportController@storeCloseTicket'])->name('support.ticket.close');

        Route::patch('/support/request/create', ['uses' => 'Support\SupportController@store'])->name('support.ticket.store');
        Route::patch('/support/request/{hash}/comment', ['uses' => 'Support\SupportController@storeComment'])->name('support.ticket.store.comment');


        Route::get('/support/api', ['uses' => 'Frontend\ContentController@showApi'])->name('support.api');
        Route::get('/support/libraries', ['uses' => 'Support\SupportController@indexLibraries'])->name('support.libraries');


        Route::get('/privacy', ['uses' => 'Pages\PageController@showPrivacy'])->name('page.privacy');
        Route::get('/login/admin', ['uses' => 'Admin\AdminController@showLoginAdmin'])->name('admin.login.admin');

        Route::group(['middleware' => 'authentication:admin', 'prefix' => 'admin'], function () {
            Route::get('/', ['uses' => 'Admin\AdminController@index'])->name('admin.index');

            Route::get('/tickets', ['uses' => 'Admin\AdminController@indexTickets'])->name('admin.tickets');
            Route::post('/tickets/ajax', ['uses' => 'Admin\AdminController@indexTicketsAjax'])->name('admin.ajax.tickets');
            Route::get('/ticket/{id}', ['uses' => 'Admin\AdminController@showTicket'])->name('admin.ticket.show');

            Route::get('/ticket/{id}/close', ['uses' => 'Admin\AdminController@updateTicketClose'])->name('admin.ticket.close');
            Route::get('/ticket/{id}/work', ['uses' => 'Admin\AdminController@updateTicketWork'])->name('admin.ticket.work');
            Route::patch('/ticket/{id}/answer', ['uses' => 'Admin\AdminController@storeTicketAnswer'])->name('admin.ticket.answer');


            Route::get('/plans', ['uses' => 'Admin\AdminController@indexPlans'])->name('admin.plans');
            Route::get('/plan/{id}', ['uses' => 'Admin\AdminController@showPlan'])->name('admin.plan.show');
            Route::post('/plan/{id}/save', ['uses' => 'Admin\AdminController@updatePlan'])->name('admin.plan.save');

            Route::get('/users', ['uses' => 'Admin\AdminController@indexUsers'])->name('admin.users');

            Route::get('/user/{id}', ['uses' => 'Admin\AdminController@showUser'])->name('admin.user.show');

            Route::get('/login/user/{id}', ['uses' => 'Admin\AdminController@showLogin'])->name('admin.login.user');


            Route::get('/delete/user_all/{id}', ['uses' => 'Admin\AdminController@destroy'])->name('admin.delete.user');

            Route::post('/update/user/profile/{id}', ['uses' => 'Admin\AdminController@updateUserProfile'])->name('admin.update.user.profile');
            Route::post('/update/user/image/{id}', ['uses' => 'Admin\AdminController@updateUserImage'])->name('admin.update.user.image');
            Route::get('/delete/user/image/{id}', ['uses' => 'Admin\AdminController@destroyUserImage'])->name('admin.delete.user.image');
            Route::post('/update/user/email/{id}', ['uses' => 'Admin\AdminController@updateUserEmail'])->name('admin.update.user.email');
            Route::post('/update/user/password/{id}', ['uses' => 'Admin\AdminController@updateUserPassword'])->name('admin.update.user.password');


            Route::post('/logins/ajax/{id}', ['uses' => 'Admin\AdminController@indexLoginsAjax'])->name('admin.ajax.logins');

            Route::post('/users/ajax', ['uses' => 'Admin\AdminController@indexUsersAjax'])->name('admin.ajax.users');

            //admin.ajax.users.json
            Route::post('/users/ajax/json', ['uses' => 'Admin\AdminController@indexUsersAjaxJson'])->name('admin.ajax.users.json');

            Route::get('/apps', ['uses' => 'Admin\AdminController@indexApps'])->name('admin.apps');
            Route::get('/app/{id}', ['uses' => 'Admin\AdminController@showApp'])->name('admin.app');
            Route::post('/app/update/{id}', ['uses' => 'Admin\AdminController@updateApp'])->name('admin.app.update');
            Route::post('/apps/ajax/{id?}', ['uses' => 'Admin\AdminController@indexAppsAjax'])->name('admin.ajax.apps');
            Route::get('/delete/app_all/{id}', ['uses' => 'Admin\AdminController@destroyApp'])->name('admin.delete.app');
            Route::post('/pushes/ajaxByApp/{id}', ['uses' => 'Admin\AdminController@indexPushesAjaxApp'])->name('admin.ajax.pushes.app');


            Route::get('/devices', ['uses' => 'Admin\AdminController@indexDevices'])->name('admin.devices');
            Route::post('/devices/ajaxApp/{id}', ['uses' => 'Admin\AdminController@indexDevicesAjaxApp'])->name('admin.ajax.app.devices');
            Route::post('/devices/ajax/{id?}', ['uses' => 'Admin\AdminController@indexDevicesAjax'])->name('admin.ajax.devices');
            Route::get('/device/{id}', ['uses' => 'Admin\AdminController@showDevice'])->name('admin.device');
            Route::post('/devices/ajaxAppByDevice/{id}', ['uses' => 'Admin\AdminController@indexDevicesAjaxAppsByDevice'])->name('admin.ajax.device.apps');
            Route::get('/delete/device/{id}', ['uses' => 'Admin\AdminController@destroyDevice'])->name('admin.delete.device');
            Route::post('/device/update/{id}', ['uses' => 'Admin\AdminController@updateDevice'])->name('admin.update.device');

            Route::get('/pushes', ['uses' => 'Admin\AdminController@indexPushes'])->name('admin.pushes');
            Route::post('/pushes/ajax', ['uses' => 'Admin\AdminController@indexPushesAjax'])->name('admin.ajax.pushes');
            Route::get('/push/{id}', ['uses' => 'Admin\AdminController@showPush'])->name('admin.push');
            Route::post('/pushes/ajaxByDevice/{id}', ['uses' => 'Admin\AdminController@indexPushesAjaxByDevice'])->name('admin.ajax.pushes.device');
            Route::get('/delete/push/{id}', ['uses' => 'Admin\AdminController@destroyPush'])->name('admin.delete.push');
            Route::post('/push/update/{id}', ['uses' => 'Admin\AdminController@updatePush'])->name('admin.update.push');


            Route::get('/notify/{id?}', ['uses' => 'Admin\AdminController@indexNotify'])->name('admin.notify');
            Route::post('/notify', ['uses' => 'Admin\AdminController@storeNotify'])->name('admin.notify.store');

        });

    });


    Route::get('/login', ['uses' => 'Auth\AuthController@getLogin'])->name('login');
    Route::post('login', 'Auth\AuthController@postLogin')->name('loginPost');

    Route::get('/register', ['uses' => 'Auth\AuthController@getRegister'])->name('register');
    Route::post('register', 'Auth\AuthController@postRegister')->name('registerPost');

    Route::get('/register/confirm/{hash}', ['uses' => 'Auth\AuthController@postConfirm'])->name('confirmPost');

    Route::get('/change/email/{hash}', ['uses' => 'Profile\ProfileController@updateMailConfirm'])->name('confirmEmail');

    Route::get('/logout', ['uses' => 'Auth\AuthController@getLogout'])->name('logout');

    // Password reset link request routes...
    Route::get('/forgot', 'Auth\PasswordController@getEmail')->name('forgotPassword');
    Route::post('/forgot', 'Auth\PasswordController@postEmail')->name('forgotPost');

// Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset')->name('resetPost');


});



Route::group(['domain' => 'pushauth.' . env('DOMAIN_LTD', 'io')], function () {

    Route::get('/', ['uses'=>'Frontend\MainController@index'])->name('frontend.index');

    Route::get('/example', ['uses'=>'Frontend\MainController@showExample'])->name('frontend.example');


    Route::post('/example', ['uses'=>'Frontend\MainController@storeExample', 'middleware' => 'GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:20,1'])->name('frontend.example.send');





    Route::get('/example/status/{id}', ['uses'=>'Frontend\MainController@showExampleStatus'])->name('frontend.example.status');
    Route::post('/example/qr/status', ['uses'=>'Frontend\MainController@checkQrCode'])->name('frontend.example.qr');

    Route::get('/blog', ['uses'=>'Frontend\BlogController@index'])->name('frontend.blog');

    Route::get('/documentation/api', ['uses'=>'Frontend\ContentController@showApi'])->name('frontend.content.api');
    Route::get('/faq', ['uses'=>'Frontend\ContentController@showFaq'])->name('frontend.content.faq');
    Route::get('/tutorial/{id?}', ['uses'=>'Frontend\ContentController@showTutorial'])->name('frontend.content.tutorial.index');
    Route::get('/team', ['uses'=>'Frontend\ContentController@showTeam'])->name('frontend.content.team');
    Route::get('/needed', ['uses'=>'Frontend\ContentController@showJobs'])->name('frontend.content.jobs');
    Route::get('/terms', ['uses'=>'Frontend\ContentController@showTerms'])->name('frontend.content.terms');
    Route::get('/policy', ['uses'=>'Frontend\ContentController@showPolicy'])->name('frontend.content.policy');






    Route::get('confirm/{hash}', ['uses' => 'Auth\ConfirmUserDeviceController@store'])->name('confirmation');


});


$api = app('Dingo\Api\Routing\Router');


$api->group(['middleware' => 'ActiveAPI', 'version' => 'v1', 'namespace' => 'PushAuth\Http\Controllers\APIControllers', 'domain' => 'api.pushauth.' . env('DOMAIN_LTD', 'io')], function ($api) {


    $api->post('/test', 'AppController@test');


    $api->get('/', 'AppController@index');

    $api->get('/push', 'AppController@testFlag');
    $api->get('/push_update/{flag}', 'AppController@updateFlag');

    //mobile
    $api->post('auth', 'AuthController@storeRegister');
    $api->post('logout', 'AuthController@storeLogout');

    $api->post('push/answer', 'PushController@storePushAnswer');
    $api->post('push/index', 'PushController@index');

    $api->post('qr/store', 'PushController@storeQR');
    $api->get('app/logo/{hash}', 'AppController@showLogo');
    $api->post('app/info', 'AppController@show');

    //app
    $api->post('qr/show', 'PushController@showQR');
    $api->get('qr/show/image/{id}', 'PushController@showQRImage');
    $api->post('push/send', 'PushController@storePushSend');
    $api->post('push/status', 'PushController@showPushStatus');

    $api->post('stats', 'AppController@showStats');

    $api->post('stripe','StripeController@store');


    //Route::get('app/logo/{hash}', ['uses'=>'APIControllers\AppController@showLogo'])->name('app.logo.show');


//TODO APP INFO JSON

//    $api->get('app/logo/{hash}', 'AppController@showLogo');


});
