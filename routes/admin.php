<?php


use App\Http\Controllers\Backend\Appearance\BannerSectionOneController;
use App\Http\Controllers\Backend\Appearance\BannerSectionTwoController;
use App\Http\Controllers\Backend\Appearance\BestDealProductsController;
use App\Http\Controllers\Backend\Appearance\BestSellingProductsController;
use App\Http\Controllers\Backend\Appearance\CertificationController;
use App\Http\Controllers\Backend\Appearance\ClientFeedbackController;
use App\Http\Controllers\Backend\Appearance\ContentController;
use App\Http\Controllers\Backend\Appearance\DistributerController;
use App\Http\Controllers\Backend\Appearance\FeaturedProductsController;
use App\Http\Controllers\Backend\Appearance\FooterController;
use App\Http\Controllers\Backend\Appearance\HeaderController;
use App\Http\Controllers\Backend\Appearance\HeroController;
use App\Http\Controllers\Backend\Appearance\ProductsPageController;
use App\Http\Controllers\Backend\Appearance\TopCategoriesController;
use App\Http\Controllers\Backend\Appearance\TopTrendingProductsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BlogSystem\BlogsController;
use App\Http\Controllers\Backend\BlogSystem\BlogCategoriesController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SubscribersController;
use App\Http\Controllers\Backend\CustomersController;
use App\Http\Controllers\Backend\StaffsController;
use App\Http\Controllers\Backend\Products\VariationsController;
use App\Http\Controllers\Backend\Products\VariationValuesController;

use App\Http\Controllers\Backend\Products\TaxesController;
use App\Http\Controllers\Backend\Products\CategoriesController;
use App\Http\Controllers\Backend\Products\ProductsController;

use App\Http\Controllers\Backend\Pages\PagesController;
use App\Http\Controllers\Backend\Tags\TagsController;
use App\Http\Controllers\Backend\Contacts\ContactUsMessagesController;
use App\Http\Controllers\Backend\Enquiries\ProductEnquiryController;
use App\Http\Controllers\Backend\MediaManager\MediaManagerController;
use App\Http\Controllers\Backend\Newsletters\NewslettersController;
use App\Http\Controllers\Backend\Orders\OrdersController;
use App\Http\Controllers\Backend\Stocks\StocksController;
use App\Http\Controllers\Backend\Stocks\LocationsController;

use App\Http\Controllers\Backend\OrderSettingsController;

use App\Http\Controllers\Backend\Roles\RolesController;
use App\Http\Controllers\Backend\Reports\ReportsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\Products\AddOnProductsController;
use App\Http\Controllers\Backend\Products\BrandsController;
use App\Http\Controllers\Backend\Recruitment\RecruitmentController;

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

# variation to create product --> also used in vendor panel




Route::group(['prefix' => 'backend'], function () {
    Route::group(['prefix' => 'products', 'middleware' => ['auth']], function () {
        Route::post('/get-variation-values', [ProductsController::class, 'getVariationValues'])->name('product.getVariationValues');
        Route::post('/new-variation', [ProductsController::class, 'getNewVariation'])->name('product.newVariation');
        Route::post('/variation-combination', [ProductsController::class, 'generateVariationCombinations'])->name('product.generateVariationCombinations');
    });


});


Route::group(
    ['prefix' => 'admin', 'middleware' => ['auth', 'admin']],
    function () {
        # dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('admin.profile.update');


        #sms settings
        Route::get('/settings/sms', [SettingsController::class, 'smsSettings'])->name('admin.settings.smsSettings');

        # settings
        Route::post('/settings/env-key-update', [SettingsController::class, 'envKeyUpdate'])->name('admin.envKey.update');
        Route::get('/settings/general-settings', [SettingsController::class, 'index'])->name('admin.generalSettings');
        Route::get('/settings/smtp-settings', [SettingsController::class, 'smtpSettings'])->name('admin.smtpSettings.index');
        Route::post('/settings/test/smtp', [SettingsController::class, 'testEmail'])->name('admin.test.smtp');
        Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');

        #payment methods
        Route::get('/settings/payment-methods', [SettingsController::class, 'paymentMethods'])->name('admin.settings.paymentMethods');
        Route::post('/settings/update-payment-methods', [SettingsController::class, 'updatePaymentMethods'])->name('admin.settings.updatePaymentMethods');

        #enquiry settings
        Route::get('/settings/enquiry-settings', [OrderSettingsController::class, 'index'])->name('admin.orderSettings');

        # social login

        Route::post('/settings/activation', [SettingsController::class, 'updateActivation'])->name('admin.settings.activation');


        # products
        Route::group(['prefix' => 'products'], function () {
            # products
            Route::get('/', [ProductsController::class, 'index'])->name('admin.products.index');
            Route::get('/add-product', [ProductsController::class, 'create'])->name('admin.products.create');
            Route::post('/product', [ProductsController::class, 'store'])->name('admin.products.store');
            Route::get('/update-product/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit');
            Route::post('/update-product', [ProductsController::class, 'update'])->name('admin.products.update');
            Route::post('/update-featured-product', [ProductsController::class, 'updateFeatured'])->name('admin.products.updateFeatureStatus');
            Route::post('/update-published-product', [ProductsController::class, 'updatePublishedStatus'])->name('admin.products.updatePublishedStatus');
            Route::get('/delete-product/{id}', [ProductsController::class, 'delete'])->name('admin.products.delete');



            # categories
            Route::get('/category', [CategoriesController::class, 'index'])->name('admin.categories.index');
            Route::get('/add-category', [CategoriesController::class, 'create'])->name('admin.categories.create');
            Route::post('/category', [CategoriesController::class, 'store'])->name('admin.categories.store');
            Route::get('/update-category/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
            Route::post('/update-category', [CategoriesController::class, 'update'])->name('admin.categories.update');
            Route::post('/update-feature-category', [CategoriesController::class, 'updateFeatured'])->name('admin.categories.updateFeatureStatus');
            Route::post('/update-top-category', [CategoriesController::class, 'updateTop'])->name('admin.categories.updateTopStatus');
            Route::get('/products/delete-category/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');


            # brands
            Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
            Route::post('/brand', [BrandsController::class, 'store'])->name('admin.brands.store');
            Route::get('/brands/edit/{id}', [BrandsController::class, 'edit'])->name('admin.brands.edit');
            Route::post('/brands/update-brand', [BrandsController::class, 'update'])->name('admin.brands.update');
            Route::post('/brands/update-status', [BrandsController::class, 'updateStatus'])->name('admin.brands.updateStatus');
            Route::get('/brands/delete/{id}', [BrandsController::class, 'delete'])->name('admin.brands.delete');


            # taxes
            Route::get('/taxes', [TaxesController::class, 'index'])->name('admin.taxes.index');
            Route::post('/tax', [TaxesController::class, 'store'])->name('admin.taxes.store');
            Route::get('/taxes/edit/{id}', [TaxesController::class, 'edit'])->name('admin.taxes.edit');
            Route::post('/taxes/update', [TaxesController::class, 'update'])->name('admin.taxes.update');
            Route::post('/taxes/update-status', [TaxesController::class, 'updateStatus'])->name('admin.taxes.updateStatus');
            Route::get('/taxes/delete/{id}', [TaxesController::class, 'delete'])->name('admin.taxes.delete');
        });

        # pages
        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', [PagesController::class, 'index'])->name('admin.pages.index');
            Route::get('/add-page', [PagesController::class, 'create'])->name('admin.pages.create');
            Route::post('/add-page', [PagesController::class, 'store'])->name('admin.pages.store');
            Route::get('/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages.edit');
            Route::post('/update-page', [PagesController::class, 'update'])->name('admin.pages.update');
            Route::get('/delete/{id}', [PagesController::class, 'delete'])->name('admin.pages.delete');
        });

        # customers
        Route::group(['prefix' => 'customers'], function () {
            Route::get('/', [CustomersController::class, 'index'])->name('admin.customers.index');
            Route::post('/update-banned-customer', [CustomersController::class, 'updateBanStatus'])->name('admin.customers.updateBanStatus');
        });

        # tags
        Route::get('/tags', [TagsController::class, 'index'])->name('admin.tags.index');
        Route::post('/tag', [TagsController::class, 'store'])->name('admin.tags.store');
        Route::get('/tags/edit/{id}', [TagsController::class, 'edit'])->name('admin.tags.edit');
        Route::post('/tags/update-tag', [TagsController::class, 'update'])->name('admin.tags.update');
        Route::get('/tags/delete/{id}', [TagsController::class, 'delete'])->name('admin.tags.delete');


        # blog system
        Route::group(['prefix' => 'blogs'], function () {
            # blogs
            Route::get('/', [BlogsController::class, 'index'])->name('admin.blogs.index');
            Route::get('/add-blog', [BlogsController::class, 'create'])->name('admin.blogs.create');
            Route::post('/add-blog', [BlogsController::class, 'store'])->name('admin.blogs.store');
            Route::get('/edit/{id}', [BlogsController::class, 'edit'])->name('admin.blogs.edit');
            Route::post('/update-blog', [BlogsController::class, 'update'])->name('admin.blogs.update');
            Route::post('/update-popular', [BlogsController::class, 'updatePopular'])->name('admin.blogs.updatePopular');
            Route::post('/update-status', [BlogsController::class, 'updateStatus'])->name('admin.blogs.updateStatus');
            Route::get('/delete/{id}', [BlogsController::class, 'delete'])->name('admin.blogs.delete');

            # categories
            Route::get('/categories', [BlogCategoriesController::class, 'index'])->name('admin.blogCategories.index');
            Route::post('/category', [BlogCategoriesController::class, 'store'])->name('admin.blogCategories.store');
            Route::get('/categories/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('admin.blogCategories.edit');
            Route::post('/categories/update-category', [BlogCategoriesController::class, 'update'])->name('admin.blogCategories.update');
            Route::get('/categories/delete/{id}', [BlogCategoriesController::class, 'delete'])->name('admin.blogCategories.delete');
        });


        # media manager
        Route::get('/media-manager', [MediaManagerController::class, 'index'])->name('admin.mediaManager.index');

        # bulk-emails
        Route::controller(NewslettersController::class)->group(function () {
            Route::get('/bulk-emails', 'index')->name('admin.newsletters.index');
            Route::post('/bulk-emails/send', 'sendNewsletter')->name('admin.newsletters.send');
        });




        # roles & permissions
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RolesController::class, 'index'])->name('admin.roles.index');
            Route::get('/add-role', [RolesController::class, 'create'])->name('admin.roles.create');
            Route::post('/add-role', [RolesController::class, 'store'])->name('admin.roles.store');
            Route::get('/update-role/{id}', [RolesController::class, 'edit'])->name('admin.roles.edit');
            Route::post('/update-role', [RolesController::class, 'update'])->name('admin.roles.update');
            Route::get('/delete-role/{id}', [RolesController::class, 'delete'])->name('admin.roles.delete');
        });



        # contact us message
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', [ContactUsMessagesController::class, 'index'])->name('admin.queries.index');
            Route::get('/mark-as-read/{id}', [ContactUsMessagesController::class, 'read'])->name('admin.queries.markRead');
        });

        # Product Enquiries
        Route::group(['prefix' => 'product-enquiries'], function () {
            Route::get('/', [ProductEnquiryController::class, 'index'])->name('admin.enquiries.index');
            Route::get('/mark-as-read/{id}', [ProductEnquiryController::class, 'read'])->name('admin.enquiries.markRead');
        });

        # appearance
        Route::group(['prefix' => 'appearance'], function () {

            # homepage - hero
            Route::get('/homepage/slider', [HeroController::class, 'hero'])->name('admin.appearance.homepage.hero');
            Route::post('/homepage/slider', [HeroController::class, 'storeHero'])->name('admin.appearance.homepage.storeHero');
            Route::get('/homepage/slider/edit/{id}', [HeroController::class, 'edit'])->name('admin.appearance.homepage.editHero');
            Route::post('/homepage/slider/update', [HeroController::class, 'update'])->name('admin.appearance.homepage.updateHero');
            Route::get('/homepage/slider/delete/{id}', [HeroController::class, 'delete'])->name('admin.appearance.homepage.deleteHero');

            # homepage - certification
            Route::get('/homepage/certification', [CertificationController::class, 'certificates'])->name('admin.appearance.homepage.certificate');
            Route::post('/homepage/certification', [CertificationController::class, 'storeCertificate'])->name('admin.appearance.homepage.storeCertificate');
            Route::get('/homepage/certification/edit/{id}', [CertificationController::class, 'edit'])->name('admin.appearance.homepage.editCertificate');
            Route::post('/homepage/certification/update', [CertificationController::class, 'update'])->name('admin.appearance.homepage.updateCertificate');
            Route::get('/homepage/certification/delete/{id}', [CertificationController::class, 'delete'])->name('admin.appearance.homepage.deleteCertificate');

            # homepage - certification
            Route::get('/homepage/content', [ContentController::class, 'contents'])->name('admin.appearance.homepage.content');
            Route::post('/homepage/content', [ContentController::class, 'storeContent'])->name('admin.appearance.homepage.storeContent');
            Route::get('/homepage/content/edit/{id}', [ContentController::class, 'edit'])->name('admin.appearance.homepage.editContent');
            Route::post('/homepage/content/update', [ContentController::class, 'update'])->name('admin.appearance.homepage.updateContent');
            Route::get('/homepage/content/delete/{id}', [ContentController::class, 'delete'])->name('admin.appearance.homepage.deleteContent');


            # homepage - top category
            Route::get('/homepage/top-category', [TopCategoriesController::class, 'index'])->name('admin.appearance.homepage.topCategories');

            # homepage - featured products
            Route::get('/homepage/featured-products', [FeaturedProductsController::class, 'index'])->name('admin.appearance.homepage.featuredProducts');

            # homepage - top trending products
            Route::get('/homepage/trending-products', [TopTrendingProductsController::class, 'index'])->name('admin.appearance.homepage.topTrendingProducts');
            Route::post('/homepage/get-products-for-trending', [TopTrendingProductsController::class, 'getProducts'])->name('admin.appearance.homepage.getProducts');

            # homepage - banner section one
            Route::get('/homepage/banner-section-one', [BannerSectionOneController::class, 'index'])->name('admin.appearance.homepage.bannerOne');
            Route::post('/homepage/banner-section-one', [BannerSectionOneController::class, 'storeBannerOne'])->name('admin.appearance.homepage.storeBannerOne');
            Route::get('/homepage/banner-section-one/edit/{id}', [BannerSectionOneController::class, 'edit'])->name('admin.appearance.homepage.editBannerOne');
            Route::post('/homepage/banner-section-one/update', [BannerSectionOneController::class, 'update'])->name('admin.appearance.homepage.updateBannerOne');
            Route::get('/homepage/banner-section-one/delete/{id}', [BannerSectionOneController::class, 'delete'])->name('admin.appearance.homepage.deleteBannerOne');

            # homepage - best deals products
            Route::get('/homepage/best-deal-products', [BestDealProductsController::class, 'index'])->name('admin.appearance.homepage.bestDeals');

            # homepage - banner section two
            Route::get('/homepage/banner-section-two', [BannerSectionTwoController::class, 'index'])->name('admin.appearance.homepage.bannerTwo');


            # homepage - best selling products
            Route::get('/homepage/best-selling-products', [BestSellingProductsController::class, 'index'])->name('admin.appearance.homepage.bestSelling');


             # homepage - Authorized Distributors

             Route::get('/homepage/authorized-distributors', [DistributerController::class, 'index'])->name('admin.appearance.homepage.distributers');

            # products - listing
            Route::get('/homepage/products', [ProductsPageController::class, 'index'])->name('admin.appearance.products.index');

            # products - details
            Route::get('/homepage/products-details', [ProductsPageController::class, 'details'])->name('admin.appearance.products.details');
            Route::post('/homepage/products-details', [ProductsPageController::class, 'storeWidget'])->name('admin.appearance.products.details.storeWidget');
            Route::get('/homepage/products-details/edit/{id}', [ProductsPageController::class, 'edit'])->name('admin.appearance.products.details.editWidget');
            Route::post('/homepage/products-details/update', [ProductsPageController::class, 'update'])->name('admin.appearance.products.details.updateWidget');
            Route::get('/homepage/products-details/delete/{id}', [ProductsPageController::class, 'delete'])->name('admin.appearance.products.details.deleteWidget');


            # header
            Route::get('/header', [HeaderController::class, 'index'])->name('admin.appearance.header');

            # footer
            Route::get('/footer', [FooterController::class, 'index'])->name('admin.appearance.footer');
        });

        # staffs
        Route::group(['prefix' => 'staffs'], function () {
            Route::get('/', [StaffsController::class, 'index'])->name('admin.staffs.index');
            Route::get('/add-staff', [StaffsController::class, 'create'])->name('admin.staffs.create');
            Route::post('/add-staff', [StaffsController::class, 'store'])->name('admin.staffs.store');
            Route::get('/update-staff/{id}', [StaffsController::class, 'edit'])->name('admin.staffs.edit');
            Route::post('/update-staff', [StaffsController::class, 'update'])->name('admin.staffs.update');
            Route::get('/delete-staff/{id}', [StaffsController::class, 'delete'])->name('admin.staffs.delete');
        });


         # staffs
         Route::group(['prefix' => 'recruitment'], function () {
            Route::get('/', [RecruitmentController::class, 'index'])->name('admin.recruitment.index');
            Route::get('/mark-as-read/{id}', [RecruitmentController::class, 'read'])->name('admin.recruitment.markRead');
        });

    }
);
