<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaManagerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartsController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactUsController;

// for clear-cache
Route::get('/cc', function() {
    
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    flash(localize('Cach-Cleared'))->success();
    return back();
})->name('clear-cache');



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'allCategories'])->name('home.categories');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


# media files routes
Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::get('/media-manager/get-files', [MediaManagerController::class, 'index'])->name('uppy.index');
    Route::get('/media-manager/get-selected-files', [MediaManagerController::class, 'selectedFiles'])->name('uppy.selectedFiles');
    Route::post('/media-manager/add-files', [MediaManagerController::class, 'store'])->name('uppy.store');
    Route::get('/media-manager/delete-files/{id}', [MediaManagerController::class, 'delete'])->name('uppy.delete');
});



# products
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/get-variation-info', [ProductController::class, 'getVariationInfo'])->name('products.getVariationInfo');
Route::post('/products/show-product-info', [ProductController::class, 'showInfo'])->name('products.showInfo');

Route::post('/products/enquiry-store', [ProductController::class, 'enquiryProductStore'])->name('products.enquiryStore');

Route::get('/download/attachment/{id}', [ProductController::class, 'downloadAttachment'])->name('downloadAttachment');

#category
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/brand/{slug}', [ProductController::class, 'index'])->name('brand.show');


# page
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('home.contactUs');
Route::get('/page/{slug}', [PageController::class, 'index'])->name('home.pages.show');


Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contactUs.store');


# blogs
Route::get('/blogs', [HomeController::class, 'allBlogs'])->name('home.blogs');
Route::get('/blogs/{slug}', [HomeController::class, 'showBlog'])->name('home.blogs.show');

# carts
Route::get('/carts', [CartsController::class, 'index'])->name('carts.index');
Route::post('/add-to-cart', [CartsController::class, 'store'])->name('carts.store');
Route::post('/update-cart', [CartsController::class, 'update'])->name('carts.update');

# checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.proceed');
Route::post('/get-ch eckout-logistics', [CheckoutController::class, 'getLogistic'])->name('checkout.getLogistic');
Route::post('/shipping-amount', [CheckoutController::class, 'getShippingAmount'])->name('checkout.getShippingAmount');
Route::post('/checkout-complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
Route::get('/orders/invoice/{code}', [CheckoutController::class, 'invoice'])->name('checkout.invoice');
Route::get('/orders/{code}/success', [CheckoutController::class, 'success'])->name('checkout.success');

#Career

Route::get('/career', [CareerController::class, 'index'])->name('career.index');
Route::post('/career/store', [CareerController::class, 'store'])->name('career.store');


require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
