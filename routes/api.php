<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActorsController;
use App\Http\Controllers\DirectorsController;
use App\Http\Controllers\PlatformsController;
use App\Http\Controllers\IdiomsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ActSerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(ActorsController::class)->prefix('actors')->group(function(){
    Route::pattern('id', '[0-9]+');//Esto valida que el id corresponda a un valor numerico en todas las rutas que lo solicite
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/update/all','bulkUpdate');
    Route::patch('/{id}','patch');
    Route::delete('/{id}','destroy');
    Route::delete('/','destroyAll');
   
});
Route::controller(DirectorsController::class)->prefix('directors')->group(function(){
    Route::pattern('id', '[0-9]+');
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/{id}','patch');
    Route::patch('/update/all','bulkUpdate');
    Route::delete('/{id}','destroy');
    Route::delete('/','destroyAll');
});
Route::controller(PlatformsController::class)->prefix('platforms')->group(function(){
    Route::pattern('id', '[0-9]+');
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/{id}','patch');
    Route::delete('/','destroyAll');
    Route::delete('/{id}','destroy');
  
});
Route::controller(IdiomsController::class)->prefix('idioms')->group(function(){
    Route::pattern('id', '[0-9]+');
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/{id}','patch');
    Route::delete('/','destroyAll');
    Route::delete('/{id}','destroy');
    
    
});
Route::controller(SeriesController::class)->prefix('series')->group(function(){
    Route::pattern('id', '[0-9]+');
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/{id}','patch');      
    Route::patch('/update/all','bulkUpdate');
    Route::delete('/','destroyAll');
    Route::delete('/{id}','destroy');
   
});
Route::controller(ActSerController::class)->prefix('casting')->group(function(){
    Route::pattern('id', '[0-9]+');
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::get('/avanzada/text','detail');
    Route::post('/','store');
    Route::post('/update/{id}','update');
    Route::patch('/{id}','patch');
    Route::patch('/update/all','bulkUpdate');
    Route::delete('/','destroyAll');
    Route::delete('/{id}','destroy');
    
});