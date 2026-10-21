<?php

// Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
// Web Controllers
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\RegisterController;
// Middlewares
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

// Admin Routes
Route::group(['prefix' => 'admin-panel', 'as' => 'admin.'], function () {
    // Admin Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showlogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'doLogin'])->name('login.post');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendOtp'])->name('forgot-password.post');
    Route::get('/otp-verification', [AdminAuthController::class, 'showOtpVerificationForm'])->name('otp-verification');
    Route::post('/otp-verification', [AdminAuthController::class, 'verifyOtp'])->name('otp-verification.post');
    Route::get('/reset-password', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset-password.post');
    Route::get('/profile', [AdminAuthController::class, 'changeProfile'])->name('profile');
    Route::post('/profile', [AdminAuthController::class, 'changeProfileSave'])->name('profile.post');
    // Admin Authenticated Routes
    Route::group(['middleware' => AdminMiddleware::class], function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', function () {
            Auth::guard('admin')->logout();

            return redirect(route('admin.login'));
        })->name('logout');

        // Admin Bulk Delete Routes
        Route::post('/faq/bulk-delete', [AdminFaqController::class, 'bulkDelete'])->name('faq.bulk-delete');
        Route::post('/enquiry/bulk-delete', [AdminEnquiryController::class, 'bulkDelete'])->name('enquiry.bulk-delete');
        Route::post('/service/bulk-delete', [AdminServiceController::class, 'bulkDelete'])->name('service.bulk-delete');
        Route::post('/registration/bulk-delete', [AdminRegisterController::class, 'bulkDelete'])->name('register.bulk-delete');
        Route::post('/page/bulk-delete', [AdminPageController::class, 'bulkDelete'])->name('page.bulk-delete');
        Route::delete('/page/{id}/remove-image', [AdminPageController::class, 'removeImage'])->name('page.remove-image');

        // Certificate Route
        Route::get('/certificate/{register?}', [AdminRegisterController::class, 'certificate'])->name('register.certificate');

        // Admin Pages Routes
        Route::resources([
            'contact' => AdminContactController::class,
            'enquiry' => AdminEnquiryController::class,
            'faq' => AdminFaqController::class,
            'service' => AdminServiceController::class,
            'register' => AdminRegisterController::class,
            'page' => AdminPageController::class,
        ]);
    });
});

// Web Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/online-registration', [RegisterController::class, 'store'])->name('register.post')->middleware(ProtectAgainstSpam::class);
Route::post('/enquiry', [ContactController::class, 'sendmail'])->name('enquiry.mail')->middleware(ProtectAgainstSpam::class);
Route::get('/{slug}', [PageController::class, 'index'])->name('page');
