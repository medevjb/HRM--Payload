<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Middleware\UserRoleManagement;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Route;

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

// Route::resource( '/users', UserController::class );

// User Authentication Pages
Route::get( '/login', [UserController::class, 'loginPage'] );
Route::get( '/registration', [UserController::class, 'regiPage'] );
Route::get( '/otp', [UserController::class, 'otpPage'] );
Route::get( '/verify', [UserController::class, 'verifyotpPage'] );
Route::get( '/reset', [UserController::class, 'resetPassPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Dashboard Pages
Route::get( '/dashboard', [UserController::class, 'dashboardPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );
// Route::get( '/profileinfo', [UserController::class, 'ProfilePage'] )
//     ->middleware( [TokenVerificationMiddleware::class] );

Route::get( '/profileingo', [UserController::class, 'ProfilePage'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// For Api Call

// User Registration
Route::post( '/userApiData', [UserController::class, 'storeAPIData'] );

// User Login
Route::post( '/userLogin', [UserController::class, 'userLogin'] );

// Send Otp To reset Password
Route::post( '/sendOTPCode', [UserController::class, 'SendOTPCode'] );

// Verified Otp
Route::post( '/verifiedOTP', [UserController::class, 'VerifiedOTP'] );

// TOken Verification
Route::post( '/pass-reset', [UserController::class, 'ResetPass'] );

// Log Out User
Route::get( '/logout', [UserController::class, 'logOut'] );

// User Profile Data
Route::get( '/user-profile', [UserController::class, 'UserProfile'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Data Full Detail
Route::post( '/user-profile-full', [UserController::class, 'UserFullProfile'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Update
Route::post( '/userUdate', [UserController::class, 'userUdate'] )
    ->middleware( [TokenVerificationMiddleware::class] );








// Employee Module
Route::get( '/employee', [UserController::class, 'userPageForAdmin'] )
    ->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/employee-list', [UserController::class, 'employeeList'] )
    ->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/single-employee-list', [UserController::class, 'singleEmployee'] )
    ->middleware( [TokenVerificationMiddleware::class] );
Route::post( '/delete-employee', [UserController::class, 'deleteEmployee'] )
    ->middleware( [TokenVerificationMiddleware::class] );









// Attendence Section
// in
Route::post('/in-employee', [AttendanceRecordController::class, 'InAttendence'])
    ->middleware( [TokenVerificationMiddleware::class] );

// Out
Route::post('/out-employee', [AttendanceRecordController::class, 'OutAttendence'])
    ->middleware( [TokenVerificationMiddleware::class] );
    
// Today Attendence
Route::get('/today-attendence', [AttendanceRecordController::class, 'getTodayAttendence'])
    ->middleware( [TokenVerificationMiddleware::class] );

// My Attendence 
Route::get('/my-attendence', [AttendanceRecordController::class, 'myAttendence'])
    ->middleware( [TokenVerificationMiddleware::class] );

// Attendence
Route::get('/attendence', [AttendanceRecordController::class,'attendencePage'])
    ->middleware( [TokenVerificationMiddleware::class] );


// All User Attendence Page
Route::get('/all-attendence', [AttendanceRecordController::class,'allAttendencePage'])
    ->middleware( [TokenVerificationMiddleware::class], [UserRoleManagement::class] );

    
// All User Attendence Page
Route::get('/all-user-attendence', [AttendanceRecordController::class,'allUserAttendence'])
    ->middleware( [TokenVerificationMiddleware::class], [UserRoleManagement::class] );


















// Leave
// Leave Page
Route::get('/leave', [LeaveController::class,'leavePage'])
    ->middleware( [TokenVerificationMiddleware::class] );

// Get My Leave History
Route::get('/leave-history', [LeaveController::class,'getMyHistory'])
    ->middleware( [TokenVerificationMiddleware::class] );

// Create Leave
Route::post('/create-leave', [LeaveController::class,'createLeave'])
    ->middleware( [TokenVerificationMiddleware::class] );

// Create Leave
Route::post('/single-leave-history', [LeaveController::class,'getSingleRecord'])
    ->middleware( [TokenVerificationMiddleware::class] );


// Delete Leave
Route::post('/delete-leave-application', [LeaveController::class,'deleteLeaveApplication'])
    ->middleware( [TokenVerificationMiddleware::class] );


// Approve Leave
Route::post('/approved-leave-application', [LeaveController::class,'appprove'])
    ->middleware( [TokenVerificationMiddleware::class] );


// Rejected Leave
Route::post('/rejected-leave-application', [LeaveController::class,'rejected'])
    ->middleware( [TokenVerificationMiddleware::class] );


// Test Header
Route::get('/test-header', [LeaveController::class,'TestHeader'])
    ->middleware( [TokenVerificationMiddleware::class] );
