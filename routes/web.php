<?php
use App\Http\Middleware\admin;
use App\Http\Middleware\user;
use App\Http\Middleware\owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin == 1) {
            return redirect()->route('Admindashboard');
        } else if (Auth::user()->is_admin == 2){
            return redirect()->route('Owner');
        }
        else {
            return redirect()->route('user-dashboard');
        }
    })->name('dashboard');
});


Route::prefix('owner')->middleware(['auth', owner::class])->group(function () {
    Route::get('/ownerdashboard', function () {
        return view('owner.index');
    })->name('Owner');

    Route::get('/owner.dormitory', function () {
        return view('owner.add-dorm');
    })->name('owner.add-dorm');

    Route::get('/owner.tenant', function () {
        return view('owner.tenant');
    })->name('owner.tenant');

    Route::get('/owner.payment', function () {
        return view('owner.payment');
    })->name('owner.payment');





});


Route::prefix('admin')->middleware(['auth', admin::class])->group(function () {
    Route::get('/Admindashboard', function () {
        return view('admin.index');
    })->name('Admindashboard');

    Route::get('/admin.dormitory', function () {
        return view('admin.add-dorm-owner');
    })->name('admin.add-dorm-owner');


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
