<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::post('/token/{token}', [\App\Http\Controllers\UserController::class, 'updateToken'])->name('user.update');

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/show', [\App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard.show');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/listusers', [\App\Http\Controllers\UserController::class, 'listusers'])->name('users.listusers');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('rooms', [\App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
    Route::post('rooms', [\App\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
    Route::post('rooms/update', [\App\Http\Controllers\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{id}', [\App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.delete');

    Route::get('faculty', [\App\Http\Controllers\FacultyController::class, 'index'])->name('faculty.index');
    Route::post('faculty', [\App\Http\Controllers\FacultyController::class, 'store'])->name('faculty.store');
    Route::post('faculty/update', [\App\Http\Controllers\FacultyController::class, 'update'])->name('faculty.update');
    Route::post('faculty/status', [\App\Http\Controllers\FacultyController::class, 'statusUpdate'])->name('faculty.status');
    Route::get('faculty/schedule', [\App\Http\Controllers\FacultyController::class, 'schedule'])->name('faculty.schedule');
    Route::get('student/schedule', [\App\Http\Controllers\FacultyController::class, 'studentSchedule'])->name('student.schedule');
    Route::delete('faculty/{id}', [\App\Http\Controllers\FacultyController::class, 'destroy'])->name('faculty.delete');


    Route::post('schedule', [\App\Http\Controllers\ScheduleController::class, 'store'])->name('schedule.store');
    Route::post('add-schedule', [\App\Http\Controllers\ScheduleController::class, 'addSchedule'])->name('schedule.add');
    Route::get('subject', [\App\Http\Controllers\ScheduleController::class, 'subject'])->name('subject');

    Route::get('block-schedule', [\App\Http\Controllers\ScheduleController::class, 'blockSchedule'])->name('block.schedule');

    // Route::get('student-schedule', [\App\Http\Controllers\ScheduleController::class, 'studentSchedule'])->name('student.schedule');

    Route::get('instructor-schedule', [\App\Http\Controllers\ScheduleController::class, 'instructorSchedule'])->name('instructor.schedule');

    Route::get('student-view', [\App\Http\Controllers\FacultyController::class, 'viewSchedule'])->name('student.view');

    Route::post('appointment', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('appointment.store');

    Route::get('course', [\App\Http\Controllers\CourseController::class, 'index'])->name('course.index');
    Route::post('course', [\App\Http\Controllers\CourseController::class, 'store'])->name('course.store');
    Route::post('course/update', [\App\Http\Controllers\CourseController::class, 'update'])->name('course.update');

    Route::post('/devicetoken', function (Request $request) {
        try {
            $request->validate([
                'token' => 'required|string',
                'userId' => 'required|string'
            ]);
            //Saves Device Token to DB
            $user = User::where('id', $request->userId)->first();
            if ($user->device_tokens == null) {
                $user->device_tokens = $request->device_token;
                $user->save();
            } else if ($user->device_tokens !== $request->device_token) {
                $user->device_tokens = $request->device_token;
                $user->update();
            }
            return response($user);
        } catch (Exception $e) {
            return response($e);
        }
    })->name('store.token');
});
