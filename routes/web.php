<?php

use App\Http\Controllers\CompanySettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Models\CompanySetting;

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
    return view('login');
})->name('loginpage');

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

     // department
     Route::resource('company_setting',CompanySettingController::class)->only(['edit','update','show']);

});
