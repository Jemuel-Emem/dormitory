<?php
use App\Http\Middleware\admin;
use App\Http\Middleware\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin == 1) {
            return redirect()->route('Admindashboard');
        } else {
            return redirect()->route('user-dashboard');
        }
    })->name('dashboard');
});


Route::prefix('admin')->middleware(['auth', admin::class])->group(function () {
    Route::get('/Admindashboard', function () {
        return view('admin.index');
    })->name('Admindashboard');

    Route::get('/admin.dormitory', function () {
        return view('admin.add-dorm');
    })->name('admin.add-dorm');


});


Route::prefix('user')->middleware(['auth', user::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.index');
    })->name('user-dashboard');


    Route::get('/user.dormitory', function () {
        return view('user.dormitory');
    })->name('user.dormitory');




});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


require __DIR__.'/auth.php';
