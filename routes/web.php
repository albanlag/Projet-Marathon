<?php
use App\Http\Controllers\AvisController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\HistoireController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ChapitreController;

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

Route::get('/', [HistoireController::class, 'main'])->name("index");
Route::get('/histoires', [HistoireController::class, 'index'])->name('histoires');
Route::get('/histoire/create', [HistoireController::class, 'create'])->name('histoires.create');
Route::get('/histoire/encours/{id}', [HistoireController::class, 'edit'])->name('histoires.encours');
Route::post('/histoire/edition', [HistoireController::class, 'store'])->name('histoires.store');
Route::get('/histoires/activate/{id}', [HistoireController::class, 'activate'])->name('histoire.activate');
Route::get('/histoire/{id}', [HistoireController::class, 'show'])->name('histoire.show');
Route::get('/avis',[AvisController::class, 'index'])->name('avis.index');
Route::get('/avis/create/{histoire_id}',[AvisController::class, 'create'])->name('avis.create');
Route::post('/avis/edit',[AvisController::class, 'store'])->name('avis.store');
Route::delete('/avis/delete/{avis_id}', [AvisController::class,'destroy'])->name('avis.delete');

Route::get('/test-vite', function () {
    return view('test-vite');
})->name("test-vite");

Route::middleware(['auth'])->group(function () {
    Route::get('/user/{userId}', [UserController::class, 'personalPage'])->name('user.personal');
});

Route::post('/user/edit', [UserController::class, 'updateAvatar'])->middleware(['auth'])->name('user.edit');

Route::get('/equipe', [EquipeController::class, 'index'])->name('equipe.index');

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

Route::get('/chapitre/{id}', [ChapitreController::class,'show'])->name('chapitres.show');
Route::post('/chapitres/store', [ChapitreController::class, 'store'])->name('chapitres.store');
Route::post('/chapitres/lien', [ChapitreController::class, 'lien'])->name('chapitres.lien');

Route::get('/review', function () {
    return view('review');
})->name("review");
