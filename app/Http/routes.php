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

// wechat
Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function () {
    Route::any('/', 'WechatController@serve');
    Route::get('/menu', 'WechatController@menu');
    Route::group(['prefix' => 'payment'], function () {
        Route::any('/notify', 'PaymentController@notify');
    });
});


// shop
Route::group(['prefix' => 'web', 'namespace' => 'Shop'], function () {
    Route::any('/index', 'WebController@index');
    Route::any('/detail', 'WebController@detail');
});
// shop
Route::group(['prefix' => 'shop', 'namespace' => 'Shop', 'middleware' => 'wechat'], function () {
    Route::any('/test', 'ShopController@test');
    Route::any('/get_code_url', 'ShopController@getCodeUrl');
    Route::any('/index', 'ShopController@index');
    Route::any('/search', 'ShopController@search');
    Route::any('/category', 'ShopController@category');
    Route::any('/activity', 'ShopController@activity');
    Route::any('/detail', 'ShopController@detail');
    Route::any('/pay', 'ShopController@pay');
    Route::any('/pay-success', 'ShopController@paySuccess');
    Route::any('/hot-category', 'ShopController@hotCategory');
    Route::any('/cart', 'CartController@index');
    Route::any('/order', 'OrderController@index');
    Route::any('/product-list', 'ShopController@productList');
    Route::any('/product-specifications', 'ShopController@productSpecifications');

    Route::group(['prefix' => 'cart'], function () {
        Route::any('add', 'CartController@add');
        Route::any('delete', 'CartController@delete');
        Route::any('update', 'CartController@update');
        Route::any('get', 'CartController@get');
        Route::any('clear', 'CartController@clear');
        Route::any('clear-all', 'CartController@clearAll');
        Route::any('count', 'CartController@count');
    });

    Route::any('/address', 'AddressController@index');
    Route::any('/select-address', 'AddressController@selectAddress');
    Route::group(['prefix' => 'address'], function () {
        Route::any('create', 'AddressController@create');
        Route::any('pay-create', 'AddressController@payCreate');
        Route::any('select-create', 'AddressController@selectCreate');
        Route::any('store', 'AddressController@store');
        Route::any('pay-store', 'AddressController@payStore');
        Route::any('select-store', 'AddressController@selectStore');
        Route::any('update', 'AddressController@update');
        Route::any('edit', 'AddressController@edit');
        Route::any('delete', 'AddressController@destroy');
        Route::any('set-default', 'AddressController@setDefault');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::any('pay', 'OrderController@pay');
        Route::any('detail', 'OrderController@detail');
        Route::any('store', 'OrderController@store');
        Route::any('delete', 'OrderController@delete');
    });


    Route::any('/personal', 'PersonalController@index');
    Route::group(['prefix' => 'personal'], function () {
        Route::any('/promote', 'PersonalController@promote');
        Route::any('/beans', 'PersonalController@beans');
        Route::any('/rule', 'PersonalController@rule');
        Route::any('/about-us', 'PersonalController@aboutUS');
    });
});

// admin
Route::group(['prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
        Route::resource('category', 'CategoryController');
        Route::resource('product', 'ProductController');
        Route::resource('supplier', 'SupplierController');
        Route::resource('activity', 'ActivityController');
        Route::resource('order', 'OrderController');
        Route::resource('user', 'UserController');
        Route::resource('specification', 'SpecificationController');
        Route::resource('banner', 'BannerController');
        Route::resource('product-banner', 'ProductBannerController');
        Route::get('down-order-excel', 'OrderController@downOrderExcel');
        Route::any('/excel', 'ProductController@excel');
        Route::any('/update-puan-id', 'ProductController@updatePuanId');

        Route::any('/product/search', 'ProductController@search');
        Route::any('/category/search', 'CategoryController@search');
        Route::any('/order/search', 'OrderController@search');

        Route::get('/', function () {
            return view('admin.index');
        });
        Route::get('logout', function () {
            Auth::logout();
            return Redirect::to('/admin/login');
        });

        Route::group(['namespace' => 'Member', 'prefix' => 'member'], function () {
            Route::get('wx-down-order-excel', 'OrderController@WxDownOrderExcel');
            Route::get('member-down-order-excel', 'OrderController@MemberDownOrderExcel');

            Route::any('order/wx-search', 'OrderController@search');
            Route::any('order/member-search', 'OrderController@search');

            Route::get('wx-order', 'OrderController@wx');
            Route::get('member-order', 'OrderController@member');
            Route::resource('product', 'ProductController');
            Route::any('product/search', 'ProductController@search');
        });
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::get('password/change', 'PasswordController@showChangePasswordForm')->name('auth.password.change');
            Route::post('password/change', 'PasswordController@changePassword')->name('auth.password.update');
        });
        Route::group(['middleware' => 'guest'], function () {
            Route::get('login', 'AuthController@showLoginForm')->name('auth.login');
            Route::post('login', 'AuthController@login');
        });
    });
});

// member
Route::any('/member/notice', function () {
    return view('member.notice');
});
Route::group(['prefix' => 'member', 'namespace' => 'Member', 'middleware' => 'member'], function () {
    Route::any('/index', 'ShopController@index');
    Route::any('/search', 'ShopController@search');
    Route::any('/category', 'ShopController@category');
    Route::any('/activity', 'ShopController@activity');
    Route::any('/detail', 'ShopController@detail');
    Route::any('/pay', 'ShopController@pay');
    Route::any('/pay-success', 'ShopController@paySuccess');
    Route::any('/hot-category', 'ShopController@hotCategory');
    Route::any('/cart', 'CartController@index');
    Route::any('/order', 'OrderController@index');
    Route::any('/product-list', 'ShopController@productList');
    Route::any('/product-specifications', 'ShopController@productSpecifications');

    Route::group(['prefix' => 'cart'], function () {
        Route::any('add', 'CartController@add');
        Route::any('delete', 'CartController@delete');
        Route::any('update', 'CartController@update');
        Route::any('get', 'CartController@get');
        Route::any('clear', 'CartController@clear');
        Route::any('clear-all', 'CartController@clearAll');
        Route::any('count', 'CartController@count');
    });

    Route::any('/address', 'AddressController@index');
    Route::any('/select-address', 'AddressController@selectAddress');
    Route::group(['prefix' => 'address'], function () {
        Route::any('create', 'AddressController@create');
        Route::any('pay-create', 'AddressController@payCreate');
        Route::any('select-create', 'AddressController@selectCreate');
        Route::any('store', 'AddressController@store');
        Route::any('pay-store', 'AddressController@payStore');
        Route::any('select-store', 'AddressController@selectStore');
        Route::any('update', 'AddressController@update');
        Route::any('edit', 'AddressController@edit');
        Route::any('delete', 'AddressController@destroy');
        Route::any('set-default', 'AddressController@setDefault');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::any('pay', 'OrderController@pay');
        Route::any('detail', 'OrderController@detail');
        Route::any('store', 'OrderController@store');
        Route::any('delete', 'OrderController@delete');
        Route::any('set-ems-num', 'OrderController@set-ems-num');
    });
});


Route::group(['prefix' => 'wx', 'namespace' => 'Wx', 'middleware' => 'wx'], function () {
    Route::any('/index', 'ShopController@index');
    Route::any('/search', 'ShopController@search');
    Route::any('/category', 'ShopController@category');
    Route::any('/activity', 'ShopController@activity');
    Route::any('/detail', 'ShopController@detail');
    Route::any('/pay', 'ShopController@pay');
    Route::any('/pay-success', 'ShopController@paySuccess');
    Route::any('/hot-category', 'ShopController@hotCategory');
    Route::any('/cart', 'CartController@index');
    Route::any('/order', 'OrderController@index');
    Route::any('/product-list', 'ShopController@productList');
    Route::any('/product-specifications', 'ShopController@productSpecifications');
	Route::any('/testshare', 'ShopController@testshare');
	

    Route::group(['prefix' => 'cart'], function () {
        Route::any('add', 'CartController@add');
        Route::any('delete', 'CartController@delete');
        Route::any('update', 'CartController@update');
        Route::any('get', 'CartController@get');
        Route::any('clear', 'CartController@clear');
        Route::any('clear-all', 'CartController@clearAll');
        Route::any('count', 'CartController@count'); 
    });

    Route::any('/address', 'AddressController@index');
    Route::any('/select-address', 'AddressController@selectAddress');
    Route::group(['prefix' => 'address'], function () {
        Route::any('create', 'AddressController@create');
        Route::any('pay-create', 'AddressController@payCreate');
        Route::any('select-create', 'AddressController@selectCreate');
        Route::any('store', 'AddressController@store');
        Route::any('pay-store', 'AddressController@payStore');
        Route::any('select-store', 'AddressController@selectStore');
        Route::any('update', 'AddressController@update');
        Route::any('edit', 'AddressController@edit');
        Route::any('delete', 'AddressController@destroy');
        Route::any('set-default', 'AddressController@setDefault');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::any('pay', 'OrderController@pay');
        Route::any('detail', 'OrderController@detail');
        Route::any('store', 'OrderController@store');
        Route::any('delete', 'OrderController@delete');
    });
});
Route::any('ems', 'TestController@ems');


