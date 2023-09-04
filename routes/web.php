<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Models\CompanySetting;
use Laragear\WebAuthn\WebAuthn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanySettingController;



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
Route::get('attendance',[AttendanceController::class,'index']);

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

});
