<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoryController;
use App\Http\Livewire\DocumentController;
use App\Http\Livewire\YearController;
use App\Http\Livewire\Createdocument;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\AsignacionesController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\ReportsController;
use App\Http\Controllers\ExportController;
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

Route::get('/', function () {
    return view('bienvenido');
});

Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
       ->name('home')
       ->middleware('IsEployee');

Route::get('categories', CategoryController::class);
Route::get('documents', DocumentController::class)->name('documents');
Route::get('years', YearController::class);
Route::get('newdocument', Createdocument::class)->name('newdocument');
Route::get('roles', RolesController::class);
Route::get('permissions', PermisosController::class);
Route::get('assigments', AsignacionesController::class);
Route::get('users', UsersController::class);
Route::get('reports', ReportsController::class);

//reportes PDF
Route::get('report/pdf/{user}/{type}/{f1}/{f2}',[ExportController::class,'reportPDF']);
Route::get('report/pdf/{user}/{type}',[ExportController::class,'reportPDF']);
