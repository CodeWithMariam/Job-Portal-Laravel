<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/jobs', [JobsController::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class,'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class,'applyJob'])->name('applyJob');
Route::post('/saved-job', [JobsController::class,'savedJob'])->name('savedJob');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class,'index'])->name('admin.users');
    Route::get('/users/{id}', [UserController::class,'edit'])->name('admin.users.edit');
    Route::post('/users/{id}', [UserController::class,'update'])->name('admin.users.update');
    Route::delete('/users', [UserController::class,'destroy'])->name('admin.users.destroy');
    Route::get('/jobs', [JobController::class,'index'])->name('admin.jobs');
    Route::get('/jobs/{id}', [JobController::class,'edit'])->name('admin.jobs.edit');
    Route::post('/update-job/{jobId}', [JobController::class,'update'])->name('admin.jobs.update');
    Route::delete('/job', [JobController::class,'destroy'])->name('admin.jobs.destroy');
    Route::get('/job-application', [JobApplicationController::class,'index'])->name('admin.jobApplications');
    Route::delete('/job-application', [JobApplicationController::class,'destroy'])->name('admin.jobApplications.destroy');


});

// Route::get('/admin/dashboard', [DashboardController::class,'index'])
//           ->name('admin.dashboard')
//           ->middleware('web','checkAdmin');


//           Route::middleware(['web', 'checkAdmin'])->group(function () {
//          Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// });



Route::get('/account/profile', [AccountController::class,'profile'])->name('account.profile');
Route::patch('/update-profile', [AccountController::class,'updateProfile'])->name('account.updateProfile');
Route::post('/update-profile-pic', [AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');
Route::post('/update-password', [AccountController::class,'updatePassword'])->name('account.updatePassword');
Route::get('/create-job', [AccountController::class,'createJob'])->name('account.createJob');
Route::post('/save-job', [AccountController::class,'saveJob'])->name('account.saveJob');
Route::get('/show-saved-job', [AccountController::class,'showSavedJobs'])->name('account.showSavedJobs');

Route::get('/my-jobs', [AccountController::class,'myJobs'])->name('account.myJobs');
Route::get('/my-jobs/edit/{jobId}', [AccountController::class,'editJob'])->name('account.editJob');
Route::post('/update-job/{jobId}', [AccountController::class,'updateJob'])->name('account.updateJob');
Route::post('/delete-job', [AccountController::class,'deleteJob'])->name('account.deleteJob');
Route::get('/my-job-applications', [AccountController::class,'myJobApplication'])->name('account.myJobApplication');
Route::post('/remove-job-applications', [AccountController::class,'removeJobs'])->name('account.removeJobs');
Route::post('/remove-saved-job', [AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');

Route::post('/account/logout', [AccountController::class,'logout'])->name('account.logout');
Route::get('/account/register', [AccountController::class,'registration'])->name('account.registration');
Route::post('/account/process-register', [AccountController::class,'processRegistration'])->name('account.processRegistration');
Route::get('/account/login', [AccountController::class,'login'])->name('account.login');
Route::post('/account/authenticate', [AccountController::class,'authenticate'])->name('account.authenticate');


Route::get('/forget-password', [AccountController::class,'forgetPassword'])->name('account.forgetPassword');
Route::post('/process-forget-password', [AccountController::class,'processForgetPassword'])->name('account.processForgetPassword');
Route::get('/reset-password/{token}', [AccountController::class,'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password', [AccountController::class,'processResetPassword'])->name('account.processResetPassword');




Route::group(['account'], function(){

    // Guest Routes
    Route::group(['middleware' => 'guest'], function(){
        // Route::get('/account/register', [AccountController::class,'registration'])->name('account.registration');
        // Route::post('/account/process-register', [AccountController::class,'processRegistration'])->name('account.processRegistration');
        // Route::get('/account/login', [AccountController::class,'login'])->name('account.login');
        // Route::post('/account/authenticate', [AccountController::class,'authenticate'])->name('account.authenticate');

    // Authenticate Routes
//     Route::group(['middleware' => 'auth'], function(){
//         Route::get('/account/profile', [AccountController::class,'profile'])->name('account.profile');
//         Route::get('/account/logout', [AccountController::class,'logout'])->name('account.logout');
// });
});
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
