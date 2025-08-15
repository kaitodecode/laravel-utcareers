<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PelamarApplicantController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name("login.post");
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/admin/dashboard', function () {
    return view("admin.dashboard");
})->name("admin.dashboard")->middleware("auth");

// Admin routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('applicants', ApplicantController::class);
    Route::get('applicants/{applicant}/selections', [ApplicantController::class, 'getSelections'])
        ->name('applicants.selections');
    Route::put('applicants/{applicant}/selections/{selection}', [ApplicantController::class, 'updateSelection'])
        ->name('applicants.selections.update');
    Route::post('applicants/upload-interview-details', [ApplicantController::class, 'uploadInterviewDetails'])
        ->name('applicants.upload-interview-details');
    Route::post('applicants/approve-medical-document', [ApplicantController::class, 'approveMedicalDocument'])
        ->name('applicants.approve-medical-document');
});

// Pelamar (Applicant) routes
Route::middleware('auth')->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard', [PelamarApplicantController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [PelamarApplicantController::class, 'applications'])->name('applications');
    Route::get('/selection-process', [PelamarApplicantController::class, 'selectionProcess'])->name('selection-process');
    Route::get('/selection-process/{application}', [PelamarApplicantController::class, 'selectionProcess'])->name('selection-process.detail');
    Route::post('/upload-document', [PelamarApplicantController::class, 'uploadDocument'])->name('upload-document');
    Route::post('/upload-portfolio', [PelamarApplicantController::class, 'uploadPortfolio'])->name('upload-portfolio');
});
