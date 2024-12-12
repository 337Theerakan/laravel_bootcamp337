<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//หน้าเเรกสุด
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//หน้า dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//หน้า โปรไฟล์ผู้ใช้ ที่มีการ เเก้ อัพ ลบ
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//การต้องค่าให้กำหนดงาน ไปที่ใหน อะไรบ้าง
Route::resource('chirps', ChirpController::class) //ไปที่ app -> Controllers -> ChirpController
    ->only(['index', 'store', 'update', 'destroy']) //ให้ทำงาน(เห็น) ตรง 'index', 'store', 'update', 'destroy ใน ChirpController
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
