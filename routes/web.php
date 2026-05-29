<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MonitoringController as UserMonitoringController;
use App\Http\Controllers\User\ProfileController;

/* =====================================================
| LOGIN
===================================================== */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

/* =====================================================
| LOGOUT
===================================================== */
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/* =====================================================
| REGISTER
===================================================== */
Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

/* =====================================================
| FORGOT PASSWORD
===================================================== */
Route::get('/forgot-password', [PasswordResetController::class, 'request'])
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetController::class, 'email'])
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'update'])
    ->name('password.update');


/* =====================================================
| DASHBOARD ADMIN
===================================================== */
Route::get('/dashboard-admin', [DashboardController::class, 'index'])
    ->middleware(['auth','role:admin'])
    ->name('dashboard.admin');


/* =====================================================
| DASHBOARD USER (UPDATED - PAKAI CONTROLLER)
===================================================== */
Route::middleware(['auth','role:user'])
    ->group(function () {

    Route::get('/dashboard-user',
        [UserDashboardController::class, 'index']
    )->name('dashboard.user');

    Route::middleware(['auth','role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

    Route::get('/profile/edit',
    [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::put('/profile/update',
    [ProfileController::class, 'update']
    )->name('profile.update');

    Route::get('/articles', function () {
    $articles = \App\Models\Article::orderByDesc('tanggal')->get();
    return view('user.articles.index', compact('articles'));
    })->name('articles.index');

    Route::get('/articles-search', function (\Illuminate\Http\Request $request) {

    $keyword = $request->keyword;

    $articles = \App\Models\Article::where('judul', 'like', "%{$keyword}%")
        ->orWhere('ringkasan', 'like', "%{$keyword}%")
        ->orderByDesc('tanggal')
        ->get();

    return response()->json($articles);

    })->name('articles.search');

    Route::get('/articles/{id}', function ($id) {
    $article = \App\Models\Article::findOrFail($id);
    return view('user.articles.show', compact('article'));
    })->name('articles.show');

    Route::get('/monitoring',
        [UserMonitoringController::class, 'index']
    )->name('monitoring.index');

    Route::get('/monitoring/export/pdf',
    [UserMonitoringController::class, 'exportPdf']
    )->name('monitoring.export.pdf');

    Route::get('/monitoring/create',
        [UserMonitoringController::class, 'create']
    )->name('monitoring.create');

    Route::post('/monitoring',
        [UserMonitoringController::class, 'store']
    )->name('monitoring.store');

    Route::get('/monitoring/{monitoring}',
        [UserMonitoringController::class, 'show']
    )->name('monitoring.show');

    Route::get('/monitoring/{monitoring}/edit',
        [UserMonitoringController::class, 'edit']
    )->name('monitoring.edit');

    Route::put('/monitoring/{monitoring}',
        [UserMonitoringController::class, 'update']
    )->name('monitoring.update');

    Route::delete('/monitoring/{monitoring}',
        [UserMonitoringController::class, 'destroy']
    )->name('monitoring.destroy');

    Route::delete('/diet-log/{id}',
        [UserDashboardController::class, 'destroyLog']
    )->name('dietlog.delete');

});

});


/* =====================================================
| ADMIN AREA
===================================================== */
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

// =======================
// PROFILE ADMIN
// =======================
Route::post('/profile/update', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profile/delete', [\App\Http\Controllers\Admin\AdminProfileController::class, 'delete'])
    ->name('profile.delete');

Route::get('/profile-form', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editProfile'])
    ->name('profile.form');

Route::post('/profile-form', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updateProfile'])
    ->name('profile.store');


/* =============================================
| ENTRY MONITORING HARIAN
============================================== */
Route::get('/monitoring/search',
    [MonitoringController::class, 'search']
)->name('monitoring.search');

Route::get('/patients/search',
    [MonitoringController::class, 'searchPatient']
)->name('patients.search');

Route::get('/monitoring', [MonitoringController::class, 'index'])
    ->name('monitoring.index');

Route::get('/monitoring/export/pdf',
[MonitoringController::class, 'exportPdf']
)->name('monitoring.export.pdf');

Route::get('/monitoring/create', [MonitoringController::class, 'create'])
    ->name('monitoring.create');

Route::get('/monitoring/{monitoring}', [MonitoringController::class, 'show'])
    ->name('monitoring.show');

Route::post('/monitoring', [MonitoringController::class, 'store'])
    ->name('monitoring.store');

Route::get('/monitoring/{monitoring}/edit', [MonitoringController::class, 'edit'])
    ->name('monitoring.edit');

Route::put('/monitoring/{monitoring}', [MonitoringController::class, 'update'])
    ->name('monitoring.update');

Route::post('/monitoring/{monitoring}/detail/{jenis}',
    [MonitoringController::class,'savePerMakan']
)->name('monitoring.detail.save');

Route::delete('/monitoring/item/{item}',
    [MonitoringController::class, 'destroyItem']
)->name('monitoring.item.destroy');

Route::delete('/monitoring/detail/{detail}',
    [MonitoringController::class, 'destroyDetail']
)->name('monitoring.detail.destroy');

Route::delete('/monitoring/{monitoring}',
    [MonitoringController::class,'destroy']
)->name('monitoring.destroy');

Route::get('/monitoring/detail/{detail}/edit',
    [MonitoringController::class, 'editDetail']
)->name('monitoring.detail.edit');


/* =============================================
| MASTER MENU
============================================== */
Route::get('/menu/generate-code/{kategori}',
    [MenuController::class, 'generateCode']
)->name('menu.generateCode');

Route::get('/menu', [MenuController::class, 'index'])
    ->name('menu.index');

Route::get('/menu/create', [MenuController::class, 'create'])
    ->name('menu.create');

Route::post('/menu', [MenuController::class, 'store'])
    ->name('menu.store');

Route::get('/menu/{kode_menu}/edit', [MenuController::class, 'edit'])
    ->name('menu.edit');

Route::put('/menu/{kode_menu}', [MenuController::class, 'update'])
    ->name('menu.update');

Route::delete('/menu/{kode_menu}', [MenuController::class, 'destroy'])
    ->name('menu.destroy');

Route::get('/menu/{kode_menu}', [MenuController::class, 'show'])
    ->name('menu.show');


/* =============================================
| MASTER PASIEN
============================================== */
Route::get('/patients', [PatientController::class, 'index'])
    ->name('patients.index');

Route::get('/patients/create', [PatientController::class, 'create'])
    ->name('patients.create');

Route::post('/patients', [PatientController::class, 'store'])
    ->name('patients.store');

Route::get('/patients/{id}', [PatientController::class, 'show'])
    ->name('patients.show');

Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])
    ->name('patients.edit');

Route::put('/patients/{id}', [PatientController::class, 'update'])
    ->name('patients.update');

Route::delete('/patients/{id}', [PatientController::class, 'destroy'])
    ->name('patients.destroy');


/* =============================================
| MASTER PENYAKIT
============================================== */
Route::get('/diseases', [DiseaseController::class, 'index'])
    ->name('diseases.index');

Route::get('/diseases/create', [DiseaseController::class, 'create'])
    ->name('diseases.create');

Route::post('/diseases', [DiseaseController::class, 'store'])
    ->name('diseases.store');

Route::get('/diseases/{id}', [DiseaseController::class, 'show'])
    ->name('diseases.show');

Route::get('/diseases/{id}/edit', [DiseaseController::class, 'edit'])
    ->name('diseases.edit');

Route::put('/diseases/{id}', [DiseaseController::class, 'update'])
    ->name('diseases.update');

Route::delete('/diseases/{id}', [DiseaseController::class, 'destroy'])
    ->name('diseases.destroy');

/* =============================================
| ENTRY ARTIKEL
============================================== */
    Route::get('/articles', [\App\Http\Controllers\Admin\ArticleController::class, 'index'])
    ->name('articles.index');

    Route::get('/articles/create', [\App\Http\Controllers\Admin\ArticleController::class, 'create'])
    ->name('articles.create');

    Route::post('/articles', [\App\Http\Controllers\Admin\ArticleController::class, 'store'])
    ->name('articles.store');

    Route::get('/articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'show'])
    ->name('articles.show');

    Route::get('/articles/{article}/edit', [\App\Http\Controllers\Admin\ArticleController::class, 'edit'])
    ->name('articles.edit');

    Route::put('/articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'update'])
    ->name('articles.update');

    Route::delete('/articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'destroy'])
    ->name('articles.destroy');

});
