<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminComentariosController;
use App\Http\Controllers\AdminConsejosController;
use App\Http\Controllers\AdminEspeciesController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\AdminEstadisticasController;

Route::get('/admin/auth',[AdminAuthController::class, 'entrar']);
Route::get('/logout',[AdminAuthController::class, 'logout'])->name('logout');

Route::middleware('admin.auth')->group(function () {

    Route::get('/', function () {
        return view('admin.panel');
    });

    Route::get('/admin', function () {
        return view('admin.panel');
    });


    Route::get('/admin/comentarios', [AdminComentariosController::class, 'index'])  ->name('admin.comentarios');
    Route::post('/admin/comentarios/{id}/eliminar',[AdminComentariosController::class, 'destroy'])->name('admin.comentarios.destroy');

  
    Route::get('/admin/consejos', [AdminConsejosController::class, 'index']) ->name('admin.consejos');
    Route::post('/admin/consejos', [AdminConsejosController::class, 'store']) ->name('admin.consejos.store');
    Route::put('/admin/consejos/{id}', [AdminConsejosController::class, 'update']) ->name('admin.consejos.update');
    Route::delete('/admin/consejos/{id}', [AdminConsejosController::class, 'destroy'])->name('admin.consejos.destroy');


    Route::get('/admin/especies', [AdminEspeciesController::class, 'index']) ->name('admin.especies');
    Route::post('/admin/especies',[AdminEspeciesController::class, 'store']) ->name('admin.especies.store');
    Route::patch('/admin/especies/{id}', [AdminEspeciesController::class, 'update']) ->name('admin.especies.update');
    Route::delete('/admin/especies/{id}', [AdminEspeciesController::class, 'destroy'])->name('admin.especies.destroy');

    Route::get('/admin/usuarios', [AdminUsuariosController::class, 'index']) ->name('admin.usuarios');
    Route::get('/admin/usuarios/{id}/editar', [AdminUsuariosController::class, 'edit']) ->name('admin.usuarios.editar');
    Route::put('/admin/usuarios/{id}', [AdminUsuariosController::class, 'update']) ->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{id}', [AdminUsuariosController::class, 'destroy'])->name('admin.usuarios.destroy');

    Route::get('/admin/estadisticas', [AdminEstadisticasController::class, 'index']) ->name('admin.estadisticas');
    Route::get('/admin/estadisticas/pdf', [AdminEstadisticasController::class, 'exportPdf']) ->name('admin.estadisticas.pdf');
    Route::get('/admin/estadisticas/xlsx', [AdminEstadisticasController::class, 'exportXlsx'])->name('admin.estadisticas.xlsx');

});