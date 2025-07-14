<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

// --- AUTH ROTALARI (Giriş/Kayıt) --- Herkese açık
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// --- GİRİŞ YAPMAYI GEREKTİREN ROTALAR ---
Route::middleware('auth:api')->group(function () {
    // Auth işlemleri
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Herkesin erişebileceği ders rotaları
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);

    // Kullanıcıların kayıt işlemleri
    Route::post('/enroll/{course_id}', [EnrollmentController::class, 'requestEnrollment']);
    Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments']);

    // --- SADECE ADMİNLERİN ERİŞEBİLECEĞİ ROTALAR ---
    Route::middleware('admin')->group(function () {
        // Admin Ders Yönetimi
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);

        // Admin Kayıt Yönetimi
        Route::get('/admin/enrollments', [EnrollmentController::class, 'listAllEnrollments']);
        Route::patch('/admin/enrollments/{enrollment_id}', [EnrollmentController::class, 'updateEnrollmentStatus']);
    });
});