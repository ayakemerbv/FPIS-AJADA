<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;


//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//// Новости (публичные)
//Route::get('/news', [NewsController::class, 'index'])->name('news.index');
//Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

//// ==============================
//// 2. Маршруты для авторизованных
//// ==============================
//Route::middleware(['auth'])->group(function () {
//
//    // Просмотр студентов
//    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
//
//    // Бронирование комнат
//    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
//
//    // Оплата
//    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
//
//    // Заявка на обслуживание (maintenance)
//    Route::post('/maintenance-request', [MaintenanceController::class, 'store'])->name('maintenance.store');
//
//    // Бронирование спортзала
//    Route::get('/gym-bookings', [GymBookingController::class, 'index'])->name('gymBookings.index');
//    Route::post('/gym-bookings', [GymBookingController::class, 'store'])->name('gymBookings.store');
//    Route::patch('/gym-bookings/{gymBooking}/confirm', [GymBookingController::class, 'confirm'])->name('gymBookings.confirm');
//    Route::patch('/gym-bookings/{gymBooking}/cancel', [GymBookingController::class, 'cancel'])->name('gymBookings.cancel');
//});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    Route::resource('news', NewsAdminController::class)->names('admin.news');
});


// Менеджерская панель
Route::middleware(['auth'])->group(function () {
    // Можно сделать своё middleware 'manager', но пока проверим внутри
    Route::get('/manager/dashboard', function() {
        // Проверка, что role == 'manager'
        if (Auth::user()->role !== 'manager') {
            return redirect('/')->with('error','Нет доступа!');
        }
        return view('manager.dashboard');
    })->name('manager.dashboard');
    Route::get('/manager/requests', [BookingController::class, 'indexForManager'])
        ->name('manager.requests');

    Route::get('/manager/requests/{id}/accept', [BookingController::class, 'accept'])
        ->name('booking.accept');

    Route::get('/manager/requests/{id}/reject', [BookingController::class, 'reject'])
        ->name('booking.reject');
});

// Студенческая панель
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->name('student.dashboard');
    Route::get('/student/personal', [StudentController::class, 'personal'])
        ->name('student.personal');
    Route::post('/student/profile/update', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');
    // Загрузка этажей и доступных комнат для бронирования
    Route::get('/floors/{building_id}', [BookingController::class, 'getFloors'])
        ->middleware('auth')
        ->name('booking.getFloors');

    Route::get('/rooms/{building_id}/{floor}', [BookingController::class, 'getRooms'])
        ->middleware('auth')
        ->name('booking.getRooms');
    Route::post('/booking/store', [BookingController::class, 'store'])
        ->middleware('auth') // студент должен быть авторизован
        ->name('booking.store');


});
