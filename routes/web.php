<?php

use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodleLoginController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\MeetingController;
use Carbon\Carbon;

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
    Route::get('/dashboard', function (Illuminate\Http\Request $request) {

        if ($request->ajax()) {
            if (auth()->user()->roles->contains('shortname', 'manager')) {
                $classrooms = auth()->user()->ownClassrooms;

                // Siapkan koleksi untuk menyimpan data siswa dan presensi
                $data = collect();

                foreach ($classrooms as $classroom) {
                    foreach ($classroom->users as $user) {
                        foreach ($classroom->meetings as $meeting) {
                            // Cek apakah siswa memiliki presensi di pertemuan tersebut
                            $attendance = $meeting->attendances()->where('user_id', $user->id)->first();

                            if ($attendance) {
                                $data->push([
                                    'classname' => $classroom->name,
                                    'fullname' => $user->full_name,
                                    'meeting' => 'Pertemuan ' . $meeting->id,
                                    'attendance_status' => $attendance ? $attendance->status : 'Belum tersedia',
                                    'date_time' => $attendance ? Carbon::parse($attendance->date_time)->format('H:i d-F-Y') : 'Belum tersedia',
                                ]);
                            }
                        }
                    }
                }
            } else {
                $user = auth()->user();
                $classrooms = $user->classrooms;

                // Siapkan koleksi untuk menyimpan data siswa dan presensi
                $data = collect();

                foreach ($classrooms as $classroom) {
                    foreach ($classroom->meetings as $meeting) {
                        // Cek apakah siswa memiliki presensi di pertemuan tersebut
                        $attendance = $meeting->attendances()->where('user_id', $user->id)->first();

                        if ($attendance) {
                            $data->push([
                                'classname' => $classroom->name,
                                'meeting' => 'Pertemuan ' . $meeting->id,
                                'attendance_status' => $attendance ? $attendance->status : 'Belum tersedia',
                                'date_time' => $attendance ? Carbon::parse($attendance->date_time)->format('H:i d-F-Y') : 'Belum tersedia',
                            ]);
                        }
                    }
                }
            }



            return datatables()->of($data)
                ->addIndexColumn() // Menambahkan nomor indeks
                ->make(true);
        }

        return view('dashboard');
    })->name('dashboard');

    // Route::get('/attendance', function () {
    //     return view('attendance.face_recognition');
    // })->name('attendance');

    Route::get('/admin/attendance/attachment', function () {
        return view('admin.attendance_attachment');
    })->name('admin.absent');

    // Route::get('/face/register', function () {
    //     return view('attendance.face_register');
    // })->name('face.register');
});

Route::prefix('user')
    ->name('user.')
    ->group(function () {
        // Proteksi routes untuk User
        Route::middleware(['auth:moodle'])->group(function () {
            Route::controller(App\Http\Controllers\UserClassroomController::class)->group(function () {
                Route::get('classroom', 'indexClassroom')->name('class.index');
                Route::get('classroom/list/{classroom:code}', 'indexMeeting')->name('class.attendance.index');
                Route::get('class/enrollment/{classroom:code}', 'enrollment')->name('class.enrollment');
                Route::get('absent/{meeting:id}', 'absentView')->name('absent.view');
                Route::post('absent/{meeting:id}', 'absentProcess')->name('absent.process');
            });

            Route::controller(FaceRecognitionController::class)->group(function () {
                Route::get('face/register', 'indexFaceRegister')->name('face.register');
                Route::post('face/register', 'createFaceRegister')->name('create.face.register');
                Route::get('face/show', 'showFaceImage')->name('face.show');
                route::get('attendance/{meeting:id}', 'indexAttendance')->name('attendance.recognition');
                route::post('attendance/{meeting:id}', 'recognize')->name('attendance.recognize');
            });
        });
    });

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Proteksi routes untuk Admin
        Route::middleware(['auth:moodle'])->group(function () {
            Route::controller(ClassroomController::class)->group(function () {
                Route::get('class', 'index')->name('class.index');
                Route::get('class/create', 'create')->name('class.create');
                Route::post('class/store', 'store')->name('class.store');
                Route::get('class/edit/{classroom:code}', 'edit')->name('class.edit');
                Route::post('class/edit/{classroom:code}', 'update')->name('class.update');
                Route::delete('class/edit/{classroom:code}', 'delete')->name('class.destroy');
                // Route::get('class/enrollment/{classroom:code}', 'enrollment')->name('class.enrollment');
            });

            Route::controller(MeetingController::class)->group(function () {
                Route::get('attendance/list/{classroom:code}', 'indexClassroom')->name('attendance.list');
                Route::get('attendance/meeting/list/{meeting:id}', 'indexMeeting')->name('attendance.meeting.list');
                Route::get('attendance/update', 'updateAttendance')->name('attendance.update');
                Route::get('absent/attachment/{appendix:id}', 'absentAttachment')->name('absent.attachment');
            });
        });
    });
