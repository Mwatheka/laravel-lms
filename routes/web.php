<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishListController;
use App\Http\Controllers\Frontend\CartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserController::class, 'Index'])->name('index');


Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user_profile');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

    // User wishlist all route
    Route::controller(WishListController::class)->group(function(){
        Route::get('/user/wishlist','AllWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-course/','GetWishlistCourse');
        Route::get('/wishlist-remove/{id}','RemoveWishlistCourse');
    });

});
// End auth middleware

require __DIR__.'/auth.php';



// Admin group middleware
Route::middleware(['auth','role:admin'])->group(function(){
  Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
  Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
  Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
  Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
  Route::get('/admin/profile/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
  Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


//Group controller for all categories. In this Controller, you wont call the controller everytime you create a new route
Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/category','AllCategory')->name('all.category');
    Route::get('/add/category','AddCategory')->name('add.category');
    Route::post('/store/category','StoreCategory')->name('store.category');
    Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
    Route::post('/update/category','UpdateCategory')->name('update.category');
    Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');


});

//Group controller for all subcategories routes. In this Controller, you won't call the controller everytime you create a new route
Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/subcategory','AllSubCategory')->name('all.subcategory');
    Route::get('/add/subcategory','AddSubCategory')->name('add.subcategory');
    Route::post('/store/subcategory','StoreSubCategory')->name('store.subcategory');
    Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
    Route::post('/update/category','UpdateCategory')->name('update.category');
    Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');


});
  //End grouped controller.


  //Group controller for all instructor routes. In this Controller, you won't call the controller everytime you create a new route
Route::controller(AdminController::class)->group(function(){
    Route::get('/all/instructor','AllInstructor')->name('all.instructor');
    Route::post('/update/user/status','UpdateUserStatus')->name('update.user.status');



});
  //End grouped controller.
});

//end admin middleware


// Admin login route
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])->name('become.instructor');

//Route to register new instructor
Route::post('/instructor/register', [AdminController::class, 'InstructorRegister'])->name('instructor.register');



//Instructor role middleware
Route::middleware(['auth','role:instructor'])->group(function(){
Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');
Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
Route::post('/instructor/profile/store', [InstructorController::class, 'InstructorProfileStore'])->name('instructor.profile.store');
Route::get('/instructor/change/password', [InstructorController::class, 'InstructorChangePassword'])->name('instructor.change.password');
Route::post('/instructor/password/update', [InstructorController::class, 'InstructorPasswordUpdate'])->name('instructor.password.update');
});

//end instructor middleware





Route::controller(CourseController::class)->group(function(){
    Route::get('/all/course','AllCourse')->name('all.course');
    Route::get('/add/courses','AddCourse')->name('add.course');
    Route::get('/subcategory/ajax/{category_id}','GetSubCategory');
    Route::post('/store/course','StoreCourse')->name('store.course');
    Route::get('/edit/course/{id}','EditCourse')->name('edit.course');
    Route::post('/update/course','UpdateCourse')->name('update.course');
    Route::post('/update/course/image', 'UpdateCourseImage')->name('update.course.image');
    Route::post('/update/course/video', 'UpdateCourseVideo')->name('update.course.video');
    Route::post('/update/course/goal', 'UpdateCourseGoal')->name('update.course.goal');
    Route::get('/delete/course/{id}', 'DeleteCourse')->name('delete.course');

});
// End Course Controller

// Course Section and lecture all route
Route::controller(CourseController::class)->group(function(){
    Route::get('/add/course/lecture/{id}','AddCourseLecture')->name('add.course.lecture');
    Route::post('/add/course/section/','AddCourseSection')->name('add.course.section');

    Route::post('/save-lecture/','SaveLecture')->name('save-lecture');

    Route::get('/edit/lecture/{id}','EditLecture')->name('edit.lecture');
    Route::post('/update/course/lecture','UpdateCourseLecture')->name('update.course.lecture');
    Route::get('/delete/lecture/{id}','DeleteLecture')->name('delete.lecture');
    Route::post('/delete/section/{id}','DeleteSection')->name('delete.section');
});


// Route accessible for all
Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login');
Route::get('/course/details/{id}/{slug}', [IndexController::class, 'CourseDetails']);
Route::get('/category/{id}/{slug}', [IndexController::class, 'CategoryCourse']);
Route::get('/subcategory/{id}/{slug}', [IndexController::class, 'SubCategoryCourse']);
Route::get('/instructor/details/{id}', [IndexController::class, 'InstructorDetails'])->name('instructor.details');
Route::post('/add-to-wishlist/{course_id}', [WishListController::class, 'AddToWishList']);



Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
Route::get('/cart/data/', [CartController::class, 'CartData']);

//Get data from the minicart
Route::get('/course/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/course/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
//End get data from minicart
//End route for all



//Route for cart
Route::controller(CartController::class)->group(function(){
    Route::get('/mycart','MyCart')->name('myCart');
    Route::get('//get-cart-course','GetCartCourse');

});
