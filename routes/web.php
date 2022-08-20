<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UserBeinCardController;
use App\Http\Controllers\LoginFacebookController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::get('login/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [LoginFacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginFacebookController::class, 'handleFacebookCallback']);

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/', [FrontController::class,'index'])->name('home');
Route::get('/article/{id}', [FrontController::class,'article'])->name('article');
Route::get('/articles', [FrontController::class,'articles'])->name('articles');
Route::get('/newSubscription', [FrontController::class,'newSubscription'])->name('newSubscription');
Route::get('/product/{id}', [FrontController::class,'redirectProduct'])->name('product-redirect');
Route::get('/product/{id}/{type}/{device_id?}', [FrontController::class,'product'])->name('product');
Route::get('/device/{id}', [FrontController::class,'device'])->name('device');
Route::get('/products/{type}/{device_id?}', [FrontController::class,'products'])->name('products');
Route::get('/offers', [FrontController::class,'offers'])->name('offers');
Route::get('/devicePackages/{device}', [FrontController::class,'devicePackages'])->name('devicePackages');
Route::get('/mainProducts', [FrontController::class,'mainProducts'])->name('mainProducts');
// Route::get('/shoppingCart', [FrontController::class,'shoppingCart'])->name('shoppingCart');
Route::get('/completeOrder/{id}/{type}/device/{device_id?}/duration/{duration?}', [FrontController::class,'completeOrder'])->name('completeOrder');
Route::post('/pay',[OrderController::class,'payment_post_url'])->name('payment_post_url');

Route::get('/redirectpayment',[OrderController::class,'payment_redirect_url'])->name('payment_redirect_url');
Route::resource('comment',CommentController::class);
Route::resource('order',OrderController::class);

Route::group(['prefix'=>'dashboard','middleware'=>['auth:sanctum', 'verified']],function(){
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/user/profile', [DashboardController::class,'userInfo'])->name('userInfo');
    Route::post('delete_user_image',[DashboardController::class,'delete_user_image'])->name('delete_user_image');
    Route::post('update_user_info',[DashboardController::class,'update_user_info'])->name('update_user_info');
    Route::resource('beinCard',UserBeinCardController::class);
    Route::post('destroy/beinCard',[UserBeinCardController::class,'destroy'])->name('beinCard.delete');
    Route::post('update/beinCard',[UserBeinCardController::class,'update'])->name('beinCard.updated');
    Route::group(['middleware'=>['manager']],function(){
        Route::resource('device',DeviceController::class);
        Route::resource('channel',ChannelController::class);
        Route::resource('package',PackageController::class);
        Route::resource('category',CategoryController::class);
        Route::resource('blog',BlogController::class);
        Route::resource('setting',SettingController::class);
        // Route::resource('offers',OfferController::class);
        Route::get('/orders',[OrderController::class,'index'])->name('orders');
        Route::post('delete_device_image',[DeviceController::class,'delete_image'])->name('delete_device_image');
        Route::post('delete_blog_image',[BlogController::class,'delete_image'])->name('delete_blog_image');
        Route::post('delete_channel_image',[ChannelController::class,'delete_image'])->name('delete_channel_image');
        Route::post('delete_channel_images',[ChannelController::class,'delete_channel_images'])->name('delete_channel_images');
        Route::post('delete_package_image',[PackageController::class,'delete_image'])->name('delete_package_image');
        Route::post('delete_setting_image',[SettingController::class,'delete_image'])->name('delete_setting_image');
        Route::post('destroy/device',[DeviceController::class,'destroy'])->name('device.delete');
        Route::post('destroy/channel',[ChannelController::class,'destroy'])->name('channel.delete');
        Route::post('destroy/package',[PackageController::class,'destroy'])->name('package.delete');
        Route::post('destroy/category',[CategoryController::class,'destroy'])->name('category.delete');
        Route::post('destroy/blog',[BlogController::class,'destroy'])->name('blog.delete');
        Route::post('destroy/offer',[OfferController::class,'destroy'])->name('offers.destroy');
        Route::post('destroy/setting',[SettingController::class,'destroy'])->name('setting.delete');
        Route::post('destroy/comment',[CommentController::class,'destroy'])->name('comment.remove');
        Route::post('restore/comment',[CommentController::class,'restore'])->name('comment.restore');
        Route::post('delete/comment',[CommentController::class,'delete'])->name('comment.delete');
        Route::post('change_published/blog',[BlogController::class,'change_published'])->name('change_published');

        Route::get('slidersList',[SettingController::class,'slidersList']);
        Route::get('mainPackages',[SettingController::class,'mainPackages']);
        Route::get('taxes',[SettingController::class,'taxes']);
        Route::get('deleted/comments/{type}',[CommentController::class,'deletedComments'])->name('deleted.comments');
        Route::get('checkDeletedComments',[CommentController::class,'deletedExist'])->name('checkDeletedComments');

        Route::post('storeSlider',[SettingController::class,'storeSlider'])->name('storeSlider');
        Route::post('storeMainPackage',[SettingController::class,'storeMainPackage'])->name('storeMainPackage');
        Route::post('storeTax',[SettingController::class,'storeTax'])->name('storeTax');
        Route::post('changeSettingStatus',[SettingController::class,'changeSettingStatus'])->name('changeSettingStatus');
        Route::post('changeTax',[SettingController::class,'changeTax'])->name('changeTax');
    });
    Route::group(['middleware'=>['owner']],function(){        
        Route::get('/user/list', [DashboardController::class,'usersList'])->name('usersList');
        Route::post('destroy/User',[DashboardController::class,'delete_user'])->name('user.destroy');
        Route::post('user/role',[DashboardController::class,'changeUserRole'])->name('user.role');
    });
});
Route::get('cartTable',[CartController::class,'cartTable']);
Route::get('get_total_labels',[CartController::class,'get_total_labels'])->name('get_total_labels');
Route::get('get_cart_counter',[CartController::class,'get_cart_counter'])->name('get_cart_counter');
Route::post('add_to_cart',[CartController::class,'add_to_cart'])->name('add_to_cart');
Route::post('remove_from_cart',[CartController::class,'remove_from_cart'])->name('remove_from_cart');
Route::post('change_cart_count',[CartController::class,'change_cart_count'])->name('change_cart_count');
