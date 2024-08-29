<?php

use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodleLoginController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\MeetingController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [MoodleLoginController::class, 'showLoginForm'])->name('show.login');
Route::post('login', [MoodleLoginController::class, 'login'])->name('login');
Route::get('logout', [MoodleLoginController::class, 'logout'])->name('logout');

// Protected routes for Admin
// Route::middleware(['auth:moodle', 'admin'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard'); // Ganti dengan controller yang sesuai jika diperlukan
//     })->name('dashboard');
// });

// Protected routes for Murid
// Route::middleware(['auth:moodle', 'murid'])->group(function () {
//     Route::get('/attendance', function () {
//         return view('attendance.face_recognition'); // Ganti dengan controller yang sesuai jika diperlukan
//     })->name('attendance');
// });

// Protected routes for Admin
Route::middleware(['auth:moodle'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/attendance/class', function () {
        return view('attendance.class');
    })->name('attendance.class');

    Route::get('/attendance/list', function () {
        return view('attendance.list');
    })->name('attendance.list');

    Route::get('/attendance', function () {
        return view('attendance.face_recognition');
    })->name('attendance');

    Route::get('/absent', function () {
        return view('attendance.absent');
    })->name('absent');

    Route::get('/face/register', function () {
        return view('attendance.face_register');
    })->name('face.register');
});

// Protected routes for Admin
Route::middleware(['auth:moodle'])->group(function () {

    // Route::get('/admin/attendance/list', function () {
    //     return view('admin.list');
    // })->name('admin.class.list');

    Route::get('/admin/attendance/show', function () {
        return view('admin.show');
    })->name('admin.class.show');
});

Route::post('/recognize', [FaceRecognitionController::class, 'recognize']);


Route::prefix('admin')
->name('admin.')
->group(function () {
    // Proteksi routes untuk Admin
    Route::middleware(['auth:moodle'])->group(function () {
        Route::controller(ClassroomController::class)->group(function() {
            Route::get('class', 'index')->name('class.index');
            Route::get('class/create', 'create')->name('class.create');
            Route::post('class/store', 'store')->name('class.store');
            Route::get('class/edit/{classroom:code}', 'edit')->name('class.edit');
            Route::post('class/edit/{classroom:code}', 'update')->name('class.update');
            Route::delete('class/edit/{classroom:code}', 'delete')->name('class.destroy');
            Route::get('class/enrollment/{classroom:code}', 'enrollment')->name('class.enrollment');
        });

        Route::controller(MeetingController::class)->group(function () {
            Route::get('attendance/list/{classroom:code}', 'index')->name('attendance.list');
        });
    });
});
