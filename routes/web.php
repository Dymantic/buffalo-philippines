<?php

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

Route::get('/', function () {
    $slides = \Dymantic\Slideshow\Slide::all();
    $featured = \App\Products\Product::where('featured', true)->take(8)->get();
    return view('front.home.page', ['banner_slides' => $slides, 'featured' => $featured]);
});

$this->get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('admin/login', 'Auth\LoginController@login');
$this->post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('map', function () {
            return view('admin.maptest');
        });

        Route::get('users', 'UsersController@index');
        Route::post('users', 'UsersController@store');
        Route::post('users/{user}', 'UsersController@update');
        Route::delete('users/{user}', 'UsersController@delete');

        Route::post('super-admins', 'SuperAdminsController@store');
        Route::delete('super-admins/{user}', 'SuperAdminsController@delete');

        Route::post('me/password', 'UserPasswordController@update');

        Route::get('slideshow/slides', 'SlidesController@index');
        Route::get('slideshow/slides/{slide}', 'SlidesController@show');

        Route::get('locations', 'LocationsController@index');
        Route::get('locations/create', 'LocationsController@create');
        Route::post('locations', 'LocationsController@store');
        Route::post('locations/{location}', 'LocationsController@update');
        Route::delete('locations/{location}', 'LocationsController@delete');

        Route::get('categories', 'CategoriesController@index');
        Route::get('categories/{category}', 'CategoriesController@show');
        Route::post('categories', 'CategoriesController@store');
        Route::post('categories/{category}', 'CategoriesController@update');
        Route::delete('categories/{category}', 'CategoriesController@delete');

        Route::post('published-categories', 'PublishedCategoriesController@store');
        Route::delete('published-categories/{category}', 'PublishedCategoriesController@delete');

        Route::get('subcategories/{subcategory}', 'SubcategoriesController@show');
        Route::post('categories/{category}/subcategories', 'SubcategoriesController@store');
        Route::post('subcategories/{subcategory}', 'SubcategoriesController@update');
        Route::delete('subcategories/{subcategory}', 'SubcategoriesController@delete');

        Route::post('published-subcategories', 'PublishedSubcategoriesController@store');
        Route::delete('published-subcategories/{subcategory}', 'PublishedSubcategoriesController@delete');

        Route::get('tool-groups/{toolGroup}', 'ToolGroupsController@show');
        Route::post('subcategories/{subcategory}/tool-groups', 'ToolGroupsController@store');
        Route::post('tool-groups/{toolGroup}', 'ToolGroupsController@update');
        Route::delete('tool-groups/{toolGroup}', 'ToolGroupsController@delete');

        Route::post('published-tool-groups', 'PublishedToolGroupsController@store');
        Route::delete('published-tool-groups/{toolGroup}', 'PublishedToolGroupsController@delete');

        Route::get('products/{product}', 'ProductsController@show');
        Route::post('categories/{category}/products', 'CategoryProductController@store');
        Route::post('subcategories/{subcategory}/products', 'SubcategoryProductController@store');
        Route::post('tool-groups/{toolGroup}/products', 'ToolGroupProductController@store');

        Route::post('products/{product}', 'ProductsController@update');
        Route::delete('products/{product}', 'ProductsController@delete');

        Route::post('published-products', 'PublishedProductsController@store');
        Route::delete('published-products/{product}', 'PublishedProductsController@delete');

        Route::post('featured-products', 'FeaturedProductsController@store');
        Route::delete('featured-products/{product}', 'FeaturedProductsController@delete');

        Route::post('products/{product}/new-until-date', 'ProductNewUntilDateController@update');

        Route::post('products/{product}/main-image', 'ProductMainImageController@store');
        Route::delete('products/{product}/main-image', 'ProductMainImageController@delete');

        Route::get('products/{product}/gallery', 'ProductGalleryController@show');
        Route::post('products/{product}/gallery-images', 'ProductGalleryImagesController@store');
        Route::delete('gallery-images/{image}', 'ProductGalleryImagesController@delete');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'services', 'namespace' => 'Services'], function () {

        Route::get('users', 'UsersController@index');

        Route::get('categories', 'CategoriesController@index');
        Route::get('categories/{category}/subcategories', 'SubcategoriesController@index');
        Route::get('subcategories/{subcategory}/tool-groups', 'ToolGroupsController@index');

        Route::get('categories/{category}/products', 'CategoryProductsController@index');
        Route::get('subcategories/{subcategory}/products', 'SubcategoryProductsController@index');
        Route::get('tool-groups/{toolGroup}/products', 'ToolGroupProductsController@index');
    });
});

