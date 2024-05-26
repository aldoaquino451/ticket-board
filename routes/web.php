<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//   return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
  Route::resource('tickets', TicketController::class)->parameters(['tickets' => 'ticket:code']);
  Route::resource('operators', OperatorController::class)->parameters(['operators' => 'operator:slug']);
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', function () {
  return Inertia::render(
    'Home',
    // [
    //   'canLogin' => Route::has('login'),
    //   'canRegister' => Route::has('register'),
    //   'laravelVersion' => Application::VERSION,
    //   'phpVersion' => PHP_VERSION,
    // ]
  );
})->name('home');
