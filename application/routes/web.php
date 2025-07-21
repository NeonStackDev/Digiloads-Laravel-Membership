<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    // blog
    Route::get('/blog','blog');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    // subscriber
    Route::post('/subscribe','subscribe')->name('subscribe');

    // shop page
    Route::get('/browse','browse')->name('browse');
    Route::get('product/{slug}/{id}', 'productDetails')->name('product.details');
    
    
    // product filtered
    Route::get('product/filtred', 'productFilter')->name('product.filtered');
    
    //  search product
    Route::get('/product/search', 'productSearch')->name('product.search');
    // filter category
    Route::get('/category-product/{id}', 'categoryProducts')->name('filter.category.products');
    // vendor page
    Route::get('/vendor-page/{slug}/{id}', 'vendorPage')->name('vendor.page');
    Route::get('/vendor-product/search/{id}', 'vendorProductSearch')->name('vendor.product.search');
    
    // pricing page
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/pricing/checkout/{id}', 'checkout')->name('pricing.checkout');
    

    // pages
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});





