<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Staff;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/register',  [HomeController::class, 'index'])->name('register');
Route::post('/register', [HomeController::class, 'index']);
Route::get('/password/confirm',  [HomeController::class, 'index'])->name('confirmpass');
Route::post('/password/confirm', [HomeController::class, 'index']);
Route::post('/password/email', [HomeController::class, 'index']);
Route::post('/password/reset', [HomeController::class, 'index']);
Route::get('/password/reset', [HomeController::class, 'index']);
Route::get('/password/reset/{token}', [HomeController::class, 'index']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('/admin')->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/realtime-dashboard', [AdminController::class, 'realtimeDashboard'])->name('admin.dashboard.realtime');
        Route::get('/timelogs', [AdminController::class, 'timelogs'])->name('admin.timelogs');
        Route::get('/timelogs/breaklogs/{id}',[AdminController::class, 'breaklogs'])->name('admin.timelogs.breaklogs');
        Route::get('/eod', [AdminController::class, 'eod'])->name('admin.eod');
        Route::post('/summary', [AdminController::class, 'daterange'])->name('admin.eod.summary');
        Route::get('/summary', [AdminController::class, 'daterange'])->name('admin.summary');
        Route::get('/eod/tasklogs/{id}',[AdminController::class, 'tasklogs'])->name('admin.timelogs.tasklogs');
        Route::post('/eod/assessment',[AdminController::class, 'updateAssessment'])->name('admin.eod.assessment');
        Route::get('/reports', [AdminController::class, 'hoursRendered'])->name('admin.reports');
        Route::post('/reports/hoursbyemployee', [AdminController::class, 'hoursByEmployee'])->name('admin.reports.hoursbyemployee');
        Route::post('/reports/daterange', [AdminController::class, 'reportsDateRange'])->name('admin.reports.daterange');
        Route::get('/employees', [AdminController::class, 'employees'])->name('admin.employees');
        Route::post('/employees/getemployee', [AdminController::class, 'getEmployee'])->name('admin.employees.getemployee');
        Route::post('/employees/editemployee', [AdminController::class, 'editEmployee'])->name('admin.employees.editemployee');
        Route::post('/employees/addemployee', [AdminController::class, 'addEmployee'])->name('admin.employees.addemployee');
        Route::post('/employees/deleteemployee', [AdminController::class, 'deleteEmployee'])->name('admin.employees.deleteemployee');
        Route::post('/employees/resetlogin', [AdminController::class, 'resetLogin'])->name('admin.employees.resetlogin');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/save', [AdminController::class, 'saveProfile'])->name('admin.profile.save');
        Route::get('/config', [AdminController::class, 'config'])->name('admin.config');
        Route::post('/config/save', [AdminController::class, 'saveConfig'])->name('admin.config.save');
        // Route::get('/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');

    });
});

Route::middleware(['auth', 'staff'])->group(function () {
    Route::prefix('/staff')->group(function (){

        Route::get('/', [StaffController::class, 'dashboard'])->name('staff.index');
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        Route::post('/dashboard/setstatus', [StaffController::class, 'setStatus'])->name('staff.setstatus');
        Route::post('/dashboard/timein', [StaffController::class, 'timeIn'])->name('staff.timein');
        Route::post('/dashboard/timeout', [StaffController::class, 'timeOut'])->name('staff.timeout');
        Route::get('/tracker', [StaffController::class, 'tracker'])->name('staff.tracker');
        Route::post('/tracker/daterange', [StaffController::class, 'trackerDateRange'])->name('staff.tracker.daterange');
        Route::get('/profile', [StaffController::class, 'profile'])->name('staff.profile');
        Route::post('/profile/save', [StaffController::class, 'saveProfile'])->name('staff.profile.save');
        Route::post('/tracker/getinfo', [StaffController::class, 'getInfo'])->name('staff.tracker.getinfo');

    });

});

Route::middleware(['auth', 'projcoo'])->group(function () {
    Route::get('/staff/mypod',[StaffController::class, 'mypod'])->name('staff.mypod');
    Route::post('/staff/addtopod',[StaffController::class, 'addToPod'])->name('staff.addtopod');
    Route::post('/staff/removefrpod',[StaffController::class, 'removeFromPod'])->name('staff.removefrpod');
    Route::post('/staff/getlogs',[StaffController::class, 'getLogs'])->name('staff.getlogs');
    Route::get('/staff/mypod/realtime',[StaffController::class, 'mypodRealtime'])->name('staff.mypod.realtime');
});
