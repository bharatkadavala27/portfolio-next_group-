<?php

use App\Http\Livewire\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\MainDocumentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\DocumentController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MiniSliderController;
use App\Http\Controllers\FrontendDocumentController;
use App\Http\Controllers\Admin\DocumentBrandController;
// use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\ContactUsDetailController;
// use App\Http\Controllers\Frontend\BrandController; // Update the import for frontend
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentsSectionsController;

Auth::routes();
use App\Http\Controllers\Frontend\ShowBrandController; // Add this line
use App\Http\Controllers\Admin\SecondSliderController; // Add this import
use App\Http\Controllers\ContactUsDetailsController; // Correct the import
use App\Http\Controllers\Frontend\FrontendController; // Correct the import
use App\Http\Controllers\Admin\ProductController; // Ensure this import is correct

Route::get('/products', Products::class);
//<---------------------------------------Frontend Controller -------------------------------------------------------->//

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('news', [NewsController::class, 'index'])->name('news');
Route::get('news/{id}', [NewsController::class, 'newsview'])->name('newsview');
Route::get('/', [SliderController::class, 'view'])->name('sliders');
Route::get('/api/categories', [CategoryController::class, 'getCategories']);
Route::get('/api/categories/{categoryId}/children', [CategoryController::class, 'getChildren']);
// Product filtering and search
Route::get('/api/products', [FrontendController::class, 'filterProducts'])->name('products.filter');
Route::get('/api/subcategories', [FrontendController::class, 'filterSubcategories'])->name('categories.filter');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/product/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('product.show');

// Cart operations
Route::post('/api/cart/add/{product}', [CartController::class, 'addToCart']);
Route::get('/api/cart', [CartController::class, 'getCartCount']);

Route::get('/about-us', [FrontendController::class, 'aboutpage']);
Route::get('/contact-us', [FrontendController::class, 'contactpage']);
Route::get('/products', [FrontendController::class, 'products']);

Route::post('/submit-form', [ContactUsController::class, 'submit']);
Route::get('/subcategory/{category_id}', [FrontendController::class, 'show'])->name('subcategory');
Route::get('/categories', [FrontendController::class, 'view'])->name('categories.index');
Route::get('/category/{id}', [FrontendController::class, 'main'])->name('category.main');
Route::get('/sub-category/{id}', [FrontendController::class, 'show'])->name('category.sub');
Route::get('/sub/sub-category/{id}', [FrontendController::class, 'show'])->name('child.category.show');

// Route::get('/child-category/{id}', [FrontendController::class, 'show'])->name('child.category.show');
Route::get('/get-children/{categoryId}', [FrontendController::class, 'getChildren']);
// Route::get('/category/{category}', [DocumentController::class, 'showCategoryDocuments'])->name('category.documents');
// Route::get('category/categoryanddocuments/documents', [FrontendDocumentController::class, 'showCategoryDocuments'])->name('category.documents');
// web.php
Route::get('/category/{id}/documents', [DownloadController::class, 'categoryDocuments'])
    ->name('category.documents');


// Add To Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


// Downloads
Route::get('/download', [DownloadController::class, 'downloadPage'])->name('download.page');


Route::get('categories', [CategoryController::class, 'view'])->name('categories.view');
Route::get('/category/{slug}', [CategoryController::class, 'viewSubcategory'])->name('category.view');


Route::get('/category/{category}/children', [CategoryController::class, 'getChildren'])->name('categories.children');
Route::get('/category/{id}/ancestors', [CategoryController::class, 'getAncestors']);
Route::get('/admin/products/subcategories/{categoryId}', [CategoryController::class, 'getSubcategories']);
Route::post(
    '/admin/categories/check-serial',
    [App\Http\Controllers\Admin\CategoryController::class, 'checkSerial']
)->name('admin.categories.checkSerial');




Route::Resource('admin/products', ProductController::class)->middleware([RoleMiddleware::class]);
Route::post(
    '/admin/products/check-serial',
    [App\Http\Controllers\Admin\ProductController::class, 'checkSerial']
)->name('admin.products.checkSerial');

Route::Resource('admin/products.attributes', AttributeController::class)->middleware([RoleMiddleware::class]);
Route::Resource('admin/products.documents', DocumentController::class)->middleware([RoleMiddleware::class]);

Route::get('admin/products/subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->middleware([RoleMiddleware::class]);
Route::post('admin/products/remove-file', [ProductController::class, 'removeFile'])->name('admin.products.remove-file');
Route::post('admin/products/remove-image', [ProductController::class, 'removeImage'])->name('admin.products.remove-image');
Route::get('admin/products/clean-up-images', [ProductController::class, 'cleanUpImages'])->name('admin.products.clean-up-images');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::get('/documents', [MainDocumentController::class, 'index'])->name('documents.index');  // To display the list or form
    Route::get('/documents/create', [MainDocumentController::class, 'create'])->name('admin.documents.create'); // For creating a new document form
    Route::post('/documents', [MainDocumentController::class, 'store'])->name('admin.documents.store');  // For storing the new document
    Route::get('/documents/edit/{id}', [MainDocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/update/{id}', [MainDocumentController::class, 'update'])->name('documents.update');
    Route::delete('documents/{id}', [MainDocumentController::class, 'destroy'])->name('admin.documents.destroy');
    Route::post('/products/remove-temp-image', [ProductController::class, 'removeTempImage']);

});

Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::get('/documents', [MainDocumentController::class, 'index'])->name('admin.documents.index');  // To display the list or form
    Route::get('/documents/create', [MainDocumentController::class, 'create'])->name('admin.documents.create'); // For creating a new document form
    Route::post('/documents', [MainDocumentController::class, 'store'])->name('admin.documents.store');  // For storing the new document
    Route::get('/documents/edit/{id}', [MainDocumentController::class, 'edit'])->name('admin.documents.edit');
    Route::put('/documents/update/{id}', [MainDocumentController::class, 'update'])->name('admin.documents.update');
    Route::delete('/documents/{id}', [MainDocumentController::class, 'destroy'])->name('admin.documents.destroy');
    Route::get('admin/documents/clean-up', [DocumentsSectionsController::class, 'cleanUpDocuments'])->name('admin.documents.clean-up');
});



Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {






    Route::get('settings/about-us', [App\Http\Controllers\Admin\AboutUsController::class, 'about']);
    Route::post('settings/about-us', [App\Http\Controllers\Admin\AboutUsController::class, 'store']);

    Route::get('/contact-us', [App\Http\Controllers\Admin\ContactUsController::class, 'adminPanel']);



    // List all videos
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

    // Show create form
    Route::get('/videos/create', [App\Http\Controllers\Admin\VideoController::class, 'create'])->name('videos.create');

    // Store new video
    Route::post('/videos/store', [App\Http\Controllers\Admin\VideoController::class, 'store'])->name('videos.store');

    // Show edit form
    Route::get('/videos/edit/{video}', [App\Http\Controllers\Admin\VideoController::class, 'edit'])->name('videos.edit');

    // Update video
    Route::post('/videos/update/{video}', [App\Http\Controllers\Admin\VideoController::class, 'update'])->name('videos.update');

    // Delete video
    Route::delete('/videos/delete/{video}', [App\Http\Controllers\Admin\VideoController::class, 'destroy'])->name('videos.destroy');




    // main-document






    //<---------------------------------------Category Controllers -------------------------------------------------------->//

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'index')->name('admin.categories.index');
        Route::get('/create', 'create')->name('admin.categories.create');
        Route::post('/', 'store')->name('admin.categories.store');
        Route::get('/{category}/edit', 'edit')->name('admin.categories.edit');
        Route::put('/{category}', 'update')->name('admin.categories.update');
        Route::delete('/{category}', 'destroy')->name('admin.categories.destroy');
    });

    //<---------------------------------------News Controllers -------------------------------------------------------->//

    Route::controller(NewsController::class)->prefix('news')->group(function () {
        Route::get('/', 'Adminindex')->name('admin.news');
        Route::get('/create', 'create')->name('admin.news.create');
        Route::post('/', 'store')->name('admin.news.store');
        Route::get('/{id}/edit', 'edit')->name('admin.news.edit');
        Route::put('/{id}', 'update')->name('admin.news.update');
        Route::delete('/{id}', 'destroy')->name('admin.news.destroy');
    });

    //<---------------------------------------Brand Controllers -------------------------------------------------------->//


    Route::controller(BrandController::class)->prefix('brands')->group(function () {
        Route::get('/', 'index')->name('admin.brands.index');
        Route::get('/create/{id?}', 'form')->name('admin.brands.create');
        Route::post('/save/{id?}', 'save')->name('admin.brands.save');
        Route::delete('/delete/{id}', 'delete')->name('admin.brands.delete');
    });
    Route::post(
        '/admin/brands/check-serial',
        [App\Http\Controllers\Admin\BrandController::class, 'checkSerial']
    )->name('admin.brands.checkSerial');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/all-slider', [DashboardController::class, 'slider']);
    Route::get('/all-slider/create', [DashboardController::class, 'create']);
});









//<---------------------------------------Slider Controllers -------------------------------------------------------->//


Route::prefix('admin')->middleware([RoleMiddleware::class])->name('admin.')->group(function () {
    Route::controller(SliderController::class)->prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{slider}/edit', 'edit')->name('edit');
        Route::put('/{slider}', 'update')->name('update');
        Route::delete('/{slider}', 'destroy')->name('destroy');
    });
});
Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::controller(SecondSliderController::class)->prefix('secondsliders')->name('admin.secondsliders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{secondSlider}/edit', 'edit')->name('edit');
        Route::put('/{secondSlider}', 'update')->name('update');
        Route::delete('/{secondSlider}', 'destroy')->name('destroy');
    });
});
Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::controller(MiniSliderController::class)->prefix('minisiders')->name('admin.minisiders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{minisiders}/edit', 'edit')->name('edit');
        Route::put('/{minisiders}', 'update')->name('update');
        Route::delete('/{minisiders}', 'destroy')->name('destroy');
    });
});

Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::get('documents-type', [DocumentTypeController::class, 'index'])->name('admin.documents-type.index');
    Route::get('documents-type/create', [DocumentTypeController::class, 'create'])->name('admin.documents-type.create');
    Route::post('documents-type', [DocumentTypeController::class, 'store'])->name('admin.documents-type.store');
    Route::get('documents-type/{documents_type}/edit', [DocumentTypeController::class, 'edit'])->name('admin.documents-type.edit');
    Route::put('documents-type/{documents_type}', [DocumentTypeController::class, 'update'])->name('admin.documents-type.update');
    Route::delete('documents-type/{documents_type}', [DocumentTypeController::class, 'destroy'])->name('admin.documents-type.destroy');

});
Route::post(
    '/admin/document-types/check-serial',
    [App\Http\Controllers\DocumentTypeController::class, 'checkSerial']
)->name('admin.document-types.checkSerial');



Route::resource('document-types', DocumentTypeController::class);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document-types', DocumentTypeController::class);
    Route::delete('document-types/{id}/remove-image', [DocumentTypeController::class, 'removeImage'])->name('document-types.remove-image');
});



//<---------------------------------------Document Category Controllers -------------------------------------------------------->//

Route::controller(DocumentCategoryController::class)->prefix('admin/document-categories')->group(function () {
    Route::get('/', 'index')->name('admin.document-categories.index');
    Route::get('/create', 'create')->name('admin.document-categories.create');
    Route::post('/', 'store')->name('admin.document-categories.store');
    Route::get('/{category}/edit', 'edit')->name('admin.document-categories.edit');
    Route::put('/{category}', 'update')->name('admin.document-categories.update');
    Route::delete('/{category}', 'destroy')->name('admin.document-categories.destroy');
    Route::delete('admin/document-categories/{id}/remove-image', [DocumentCategoryController::class, 'removeImage'])->name('admin.document-categories.remove-image');
});

Route::post(
    '/admin/document-categories/check',
    [App\Http\Controllers\Admin\DocumentCategoryController::class, 'checkLive']
)->name('admin.document-categories.check');

Route::post(
    '/admin/document-categories/check-serial',
    [App\Http\Controllers\Admin\DocumentCategoryController::class, 'checkSerial']
)->name('admin.document-categories.checkSerial');

Route::get('admin/document-category', [DocumentCategoryController::class, 'index'])->name('admin.document-category.index');

Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::controller(DocumentBrandController::class)->prefix('document-brands')->group(function () {
        Route::get('/', 'index')->name('admin.document-brands.index');
        Route::get('/create', 'create')->name('admin.document-brands.create');
        Route::post('/save/{id?}', 'save')->name('admin.document-brands.save');
        Route::get('/{id}/edit', 'edit')->name('admin.document-brands.edit');
        Route::delete('/{id}', 'destroy')->name('admin.document-brands.destroy');
        Route::delete('/{id}/remove-image', 'removeImage')->name('admin.document-brands.remove-image');
    });
});
Route::post(
    '/admin/brands/check-serial',
    [App\Http\Controllers\Admin\BrandController::class, 'checkSerial']
)->name('admin.brands.checkSerial');


Route::post(
    '/admin/document-brands/check-serial',
    [App\Http\Controllers\Admin\DocumentBrandController::class, 'checkSerial']
)->name('admin.document-brands.checkSerial');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document-brands', DocumentBrandController::class);
    Route::resource('document-brand', DocumentBrandController::class);
});

Route::get('admin/main-documents/create', [DocumentController::class, 'create'])->name('main-documents.create');

Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::controller(DocumentCategoryController::class)->prefix('document-category')->group(function () {
        Route::get('/', 'index')->name('admin.document-category.index');
        Route::get('/create', 'create')->name('admin.document-category.create');
        Route::post('/', 'store')->name('admin.document-category.store');
        Route::get('/{category}/edit', 'edit')->name('admin.document-category.edit');
        Route::put('/{category}', 'update')->name('admin.document-category.update');
        Route::delete('/{category}', 'destroy')->name('admin.document-category.destroy');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('main-documents', DocumentCategoryController::class);
    Route::resource('document-category', App\Http\Controllers\Admin\DocumentCategoryController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document-categories', DocumentCategoryController::class);
    Route::get('document-categories/{category}/edit', [DocumentCategoryController::class, 'edit'])->name('document-categories.edit');
    Route::put('document-categories/{category}', [DocumentCategoryController::class, 'update'])->name('document-categories.update');
});

Route::resource('admin/main-documents', DocumentsSectionsController::class);


Route::get('/admin/document-sections/create', [DocumentsSectionsController::class, 'create'])->name('admin.document-sections.create');
Route::post('/admin/document-sections/store', [DocumentsSectionsController::class, 'store'])->name('admin.document-sections.store');
Route::post('admin/documents-sections/remove-file', [DocumentsSectionsController::class, 'removeFile'])->name('admin.documents-sections.remove-file');
Route::prefix('admin')->middleware([RoleMiddleware::class])->name('admin.')->group(function () {
    Route::resource('documents-sections', DocumentsSectionsController::class);
    Route::post('documents-sections/delete-file', [DocumentsSectionsController::class, 'deleteFile'])->name('documents-sections.delete-file');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document-category', DocumentCategoryController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document-categories', DocumentCategoryController::class);
    Route::get('document-categories/{category}/edit', [DocumentCategoryController::class, 'edit'])->name('document-categories.edit');
    Route::post('documents-sections/delete-file', [DocumentsSectionsController::class, 'deleteFile'])->name('documents-sections.delete-file');
});
// Download Routes
Route::get('/download', [DownloadController::class, 'downloadPage'])->name('download.page');
Route::get('/fetch-subcategories', [DownloadController::class, 'fetchSubcategories'])->name('fetch.subcategories');
// Route::get('/filter-documents', [DownloadController::class, 'filterDocuments'])->name('filter.documents');
Route::get('/category/{id}/documents', [DownloadController::class, 'categoryDocuments'])->name('category.documents');

Route::get('/fetch-document-types', [DownloadController::class, 'fetchDocumentTypes'])->name('fetch.document.types');
Route::get('/fetch-document-brands', [DownloadController::class, 'fetchDocumentBrands'])->name('fetch.document.brands');
Route::get('/fetch-document-languages', [DownloadController::class, 'fetchDocumentLanguages'])->name('fetch.document.languages');

Route::get('/brand', [ShowBrandController::class, 'index'])->name('brand');
Route::get('/brand/{id}', [ShowBrandController::class, 'show'])->name('brand.show');
Route::get('/brand/{brand_id}/category/{category_id}', [ShowBrandController::class, 'showCategoryWithBrand'])->name('brand.category.show');
Route::get('/brand/{id}/products', [ShowBrandController::class, 'showProducts'])->name('brand.products');


Route::get('/admin/contact-us-details', [ContactUsDetailsController::class, 'create']);
Route::post('/admin/contact-us-details', [ContactUsDetailsController::class, 'store']);
Route::post('/admin/contact-us-details', [ContactUsDetailsController::class, 'store']);
Route::post('/admin/contact-us-details', [ContactUsDetailController::class, 'store']);
Route::get('admin/contact-us-details/index', [ContactUsDetailsController::class, 'index'])->name('contact-us-details.index');
Route::delete('admin/contact-us-details/{id}', [ContactUsDetailsController::class, 'destroy'])->name('contact-us-details.destroy');
Route::get('admin/contact-us-details/{id}/edit', [ContactUsDetailsController::class, 'edit'])->name('contact-us-details.edit');
Route::put('admin/contact-us-details/{id}', [ContactUsDetailsController::class, 'update'])->name('contact-us-details.update');

Route::post('/admin/contact-us-details', [ContactUsDetailsController::class, 'store']);




Route::get('/contact-us/create', [App\Http\Controllers\Frontend\ContactUsController::class, 'create']);
Route::post('/contact-us', [App\Http\Controllers\Frontend\ContactUsController::class, 'store']);



// DocumentCategory
Route::get('/fetch-categories', [CategoryController::class, 'fetchCategories'])->name('fetch.categories');

Route::get('/fetch-document-types', [DocumentTypeController::class, 'fetchDocumentTypes'])->name('fetch.document.types');

Route::get('/fetch-document-categories', [DocumentController::class, 'fetchDocumentCategories'])->name('fetch.document.categories');
Route::post('/documents/filter', [DocumentController::class, 'filterDocuments'])->name('documents.filter');


// Route::get('/fetch-document-categories', [DocumentCategoryController::class, 'fetchDocumentCategories'])->name('fetch.document.categories');

Route::get('/fetch-document-brands', [DocumentBrandController::class, 'fetchDocumentBrands'])->name('fetch.document.brands');

Route::get('/fetch-document-categories', [App\Http\Controllers\Admin\DocumentCategoryController::class, 'fetchDocumentCategories'])->name('fetch.document.categories');

Route::get('/category-documents', [DocumentController::class, 'showCategoryDocuments']);

// Document Routes
Route::get('category/categoryanddocuments/documents', [FrontendDocumentController::class, 'showCategoryDocuments'])->name('category.documents');
Route::get('/fetch-document-categories', [FrontendDocumentController::class, 'fetchDocumentCategories'])->name('fetch.document.categories');
Route::get('/fetch-document-types', [FrontendDocumentController::class, 'fetchDocumentTypes'])->name('fetch.document.types');
Route::get('/fetch-document-brands', [FrontendDocumentController::class, 'fetchDocumentBrands'])->name('fetch.document.brands');
Route::get('/filter-documents', [FrontendDocumentController::class, 'filterDocuments'])->name('filter.documents');

Route::prefix('admin')->name('admin.')->middleware([RoleMiddleware::class])->group(function () {
    Route::resource('documents-sections', DocumentsSectionsController::class);
});
Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::controller(App\Http\Controllers\Admin\TwoImageSliderController::class)->prefix('twoimageslider')->name('admin.twoimageslider.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{twoImageSlider}/edit', 'edit')->name('edit');
        Route::put('/{twoImageSlider}', 'update')->name('update');
        Route::delete('/{twoImageSlider}', 'destroy')->name('destroy');
    });
});


Route::prefix('admin')->middleware([RoleMiddleware::class])->group(function () {
    Route::get('/filters', [FilterController::class, 'index'])->name('admin.filters.index');   // list filters
    Route::get('/filters/create', [FilterController::class, 'create'])->name('admin.filters.create'); // create form
    Route::post('/filters/store', [FilterController::class, 'store'])->name('admin.filters.store');   // save filter + options
    Route::post('/filters/sequence-update', [FilterController::class, 'updateSequence'])->name('admin.filters.sequence-update'); // update sequence
    Route::get('/filters/{id}/edit', [FilterController::class, 'edit'])->name('admin.filters.edit');  // edit filter
    Route::put('/filters/{id}/update', [FilterController::class, 'update'])->name('admin.filters.update'); // update
    Route::delete('/filters/{id}/delete', [FilterController::class, 'destroy'])->name('admin.filters.destroy'); // delete
});

