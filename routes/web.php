<?php

use App\Enums\SupportStatus;
use App\Http\Controllers\Admin\{SupportController};
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;


//Route::resource('/supports', SupportController::class);
Route::get("/test", function(){
dd(array_column(SupportStatus::cases(), 'name'));
});

Route::delete('/supports/{id}', [SupportController::class, 'destroy'])->name('supports.destroy');

Route::put('/supports/{id}', [SupportController::class, 'update'])->name('supports.update');

Route::get('/supports/{id}/edit', [SupportController::class, 'edit'])->name('supports.edit');

Route::get('/supports/create', [SupportController::class, 'create'])->name('supports.create');

Route::get('/supports/{id}', [SupportController::class, 'show'])->name('supports.show');

Route::post('/supports', [SupportController::class, 'store'])->name('supports.store');



//Comando para definir um nome para rota
Route::get('/supports', [SupportController::class, 'index'])->name('supports.index');

Route::get('/contacto', [SiteController::class, 'contact']
);

Route::get('/', function () {
    return view('welcome');
});
