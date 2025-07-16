
<?php 
use App\Http\Middleware\LanguageSwitch;
use App\Http\Controllers\AuthController;

Route::prefix('users')->controller(AuthController::class)->group(function() {

    // Routes that need LanguageSwitch
    Route::middleware(LanguageSwitch::class)->group(function () {
        Route::get('/signup', 'signupform')->name('auth.signup');
        Route::get('/login', 'loginform')->name('auth.login');
    });

    // Routes without the middleware
    Route::post('/signup/submit', 'signup')->name('auth.signup.submit');
    Route::post('/login/submit', 'login')->name('auth.login.submit');
    Route::post('/logout', 'logout')->name('auth.logout');
});
