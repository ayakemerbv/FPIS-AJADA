<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GymBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\ManagerUserController;
use App\Http\Controllers\Manager\NewsManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Auth;
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
Route::middleware(['auth', ])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/requests', [BookingController::class, 'indexForManager'])->name('manager.requests');
    Route::get('/manager/requests/{id}/accept', [BookingController::class, 'accept'])->name('booking.accept');
    Route::get('/manager/requests/{id}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::resource('manager/news', NewsManagerController::class)->names('manager.news');
    Route::get('manager/users/create', [ManagerUserController::class, 'create'])->name('manager.users.create');
    Route::post('manager/users', [ManagerUserController::class, 'store'])->name('manager.users.store');
    Route::get('manager/users', [ManagerUserController::class, 'index'])->name('manager.users.index');

});

// Студенческая панель
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/personal', [StudentController::class, 'personal'])->name('student.personal');
    Route::post('/student/profile/update', [StudentController::class, 'updateProfile', 'update'])->name('student.profile.update');
    Route::patch('/student/profile/update', [StudentController::class, 'update'])->name('student.profile.update');
    Route::get('/floors/{building_id}', [BookingController::class, 'getFloors'])->name('booking.getFloors');
    Route::get('/rooms/{building_id}/{floor}', [BookingController::class, 'getRooms'])->name('booking.getRooms');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/change-room', [BookingController::class, 'changeRoom'])->name('booking.changeRoom');
    Route::post('/sports/store', [GymBookingController::class, 'store'])->name('sports.store');
    Route::delete('/sports', [GymBookingController::class, 'cancel'])->name('sports.cancel');
    Route::get('/sports', [GymBookingController::class, 'showSportsPage'])->name('sports.page');
    Route::get('/refresh-user', function () {
        Auth::user()->refresh();
        return back();
    })->name('refresh.user');

// Запросы на ремонты
    Route::get('student/personal/create-request', [RequestController::class, 'create'])->name('request.create');
    Route::post('student/personal', [RequestController::class, 'store'])->name('request.store');
    Route::get('student/personal/requests', [RequestController::class, 'index'])->name('request.index');
    Route::get('student/personal/requests/{id}', [RequestController::class, 'show'])->name('request.show');
    Route::get('student/personal/requests/{id}/edit', [RequestController::class, 'edit'])->name('request.edit');
    Route::put('student/personal/requests/{repairRequest}', [RequestController::class, 'update'])->name('request.update');
    Route::delete('student/personal/requests/{repairRequest}', [RequestController::class, 'destroy'])->name('request.destroy');
// Employee dashboard
    Route::middleware(['auth', ])->group(function () {
        Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
        Route::get('employee/dashboard/requests', [EmployeeController::class, 'requests'])->name('employee.requests');
        Route::get('employee/dashboard/requests/{id}', [EmployeeController::class, 'show'])->name('employee.request.show');
        Route::get('employee/dashboard/requests/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.request.edit');
        Route::put('employee/dashboard/requests/{id}', [EmployeeController::class, 'update'])->name('employee.request.update');

    });
});
