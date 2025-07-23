
<?php 
use App\Http\Controllers\User;
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

Route::prefix('user')->controller(User::class)->group(function(){
    Route::get('/' , 'index')->name('user.profile');

    // Chat Routes 
    Route::get('/messages','messages')->name('user.messages'); // GET ALL MESSAGES ; 
    Route::get('/messages/{receiver_id}' , 'chat')->name('user.chat'); // GET ALL MESSAGES RELATED TO RECEIVER OR SENDER ; 
    Route::post('/message/{receiver_id}/send' ,'send_message')->name('user.send-message');
    Route::post('/message/typing' , 'typing')->name('user.typing');
    Route::post('/online' , 'online')->name('user.is-online');
    Route::post('/offline','offline')->name('user.is-offline');
});
