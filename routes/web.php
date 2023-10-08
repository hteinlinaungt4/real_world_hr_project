<?php

use App\Models\CompanySetting;
use App\Models\CheckinCheckout;
use Laragear\WebAuthn\WebAuthn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CheckinCheckoutController;



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

// Route::view('welcome');

// WebAuthn Routes
WebAuthn::routes();
Route::get('/',[ProfileController::class,'loginpage'])->name('loginpage');
Route::get('/logincomponent',[ProfileController::class,'optionlogin'])->name('optionlogin');
Route::get('checkin-checkout',[CheckinCheckoutController::class,'index']);
Route::get('pincode',[CheckinCheckoutController::class,'pincode']);

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // employee
    Route::resource('employee',EmployeeController::class);
    Route::get('ssd/employee',[EmployeeController::class,'ssd']);
    // department
    Route::resource('department',DepartmentController::class);
    Route::get('ssd/department',[DepartmentController::class,'ssd']);
    // role
    Route::resource('role',RoleController::class);
    Route::get('ssd/role',[RoleController::class,'ssd'])->name('role.ssd');
    // permission
    Route::resource('permission',PermissionController::class);
    Route::get('ssd/permission',[PermissionController::class,'ssd'])->name('permission.ssd');
    // profile
    Route::get('profile',[ProfileController::class,'profile']);
    // department
    Route::resource('company_setting',CompanySettingController::class)->only(['edit','update','show']);

    // attendance
    Route::resource('attendance',AttendanceController::class);
    Route::get('ssd/attendance',[AttendanceController::class,'ssd']);
    Route::get('attendance_overview',[AttendanceController::class,'overview'])->name('attendance_overview');
    Route::get('attendance_overview_table',[AttendanceController::class,'overview_table'])->name('attendance_overview_table');

    //myattendance
    Route::get('ssd/myattendance',[MyAttendanceController::class,'ssd']);
    Route::get('myattendance_overview_table',[MyAttendanceController::class,'overview_table'])->name('myattendance_overview');





    // scan
    Route::get('/attendance-scan',[AttendanceScanController::class,'scan'])->name('attendance_scan');
    Route::post('store/attendance-scan',[AttendanceScanController::class,'store'])->name('qrscan');

});
