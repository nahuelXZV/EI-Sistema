<?php

use App\Livewire\System\Area\CreateArea;
use App\Livewire\System\Area\EditArea;
use App\Livewire\System\Area\ListArea;
use App\Livewire\System\Dashboard\Home;
use App\Livewire\System\Position\CreatePosition;
use App\Livewire\System\Position\EditPosition;
use App\Livewire\System\Position\ListPosition;
use App\Livewire\System\Role\CreateRole;
use App\Livewire\System\Role\EditRole;
use App\Livewire\System\Role\ListRole;
use App\Livewire\System\User\CreateUser;
use App\Livewire\System\User\EditUser;
use App\Livewire\System\User\ListUser;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', Home::class)->name('dashboard');

    // user routes
    Route::group(['prefix' => 'user'], function () {
        Route::get('/list', ListUser::class)->name('user.list');
        Route::get('/new', CreateUser::class)->name('user.new');
        Route::get('/edit/{user}', EditUser::class)->name('user.edit');
    });

    // role routes
    Route::group(['prefix' => 'role'], function () {
        Route::get('/list', ListRole::class)->name('role.list');
        Route::get('/new', CreateRole::class)->name('role.new');
        Route::get('/edit/{role}', EditRole::class)->name('role.edit');
    });

    // position routes
    Route::group(['prefix' => 'position'], function () {
        Route::get('/list', ListPosition::class)->name('position.list');
        Route::get('/new', CreatePosition::class)->name('position.new');
        Route::get('/edit/{position}', EditPosition::class)->name('position.edit');
    });

    // area routes
    Route::group(['prefix' => 'area'], function () {
        Route::get('/list', ListArea::class)->name('area.list');
        Route::get('/new', CreateArea::class)->name('area.new');
        Route::get('/edit/{area}', EditArea::class)->name('area.edit');
    });
});
