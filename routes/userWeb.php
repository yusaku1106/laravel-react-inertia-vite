<?php

use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| User Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check())
    {
        return redirect('/home');
    }

    return redirect('/login');
});

Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('user.logout');

    // 仮登録後にメールを送信したことをユーザーに表示する画面
    Route::get('/email/verify', function (Request $request) {
        if ($request->user()->hasVerifiedEmail())
        {
            return redirect()->intended('/home');
        }

        return Inertia::render('User/Auth/VerifyEmail');
    })->name('verification.notice');

    // 仮登録メールに載っているリンクのアクセス先
    Route::get('/email/verfy/{id}/{hash}', function (EmailVerificationRequest $request) {
        // EmailVerificationRequestでidとhashを自動で検証する
        $request->fulfill();

        return redirect('/home');
    })->middleware('signed')->name('verification.verify');

    // 確認メールの再送信
    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail())
        {
            return redirect()->intended('/home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', '確認メールを再送しました');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->group(function() {
        Route::get('home', function () {
            return Inertia::render('User/Home');
        })->name('user.home');
    });
});
