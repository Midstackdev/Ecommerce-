<?php

use App\Models\Category;

Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');
