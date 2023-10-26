<?php

use App\Http\Controllers\Authenticate;
use App\Http\Controllers\Register;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Token;
use App\Http\Controllers\Services\Key;
use App\Http\Controllers\Services\KeyIpAddressRestriction;
use App\Http\Controllers\Services\KeyWebsiteRestriction;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [Authenticate::class, 'login'])->name('login');
Route::post('/google-login', [Authenticate::class, 'googleLogin'])->name('googleLogin');
Route::post('/register', [Register::class, 'register'])->name('register');
Route::post('/google-register', [Register::class, 'googleRegister'])->name('google-register');
Route::get('/logout', [Authenticate::class, 'logout'])->name('logout');
Route::prefix('profile')->group(function () {
    Route::patch('/update', [Profile::class, 'update'])->name('update-profile');
    Route::get('/show', [Profile::class, 'show'])->name('show-profile');
});
Route::middleware(['authenticator'])->group(function () {
    Route::get('/token-info', [Token::class, 'info'])->name('token-info');
    Route::prefix('services')->group(function () {
        Route::prefix('key')->group(function () {
            Route::post('generate', [Key::class, 'store'])->name('generate-key');
            Route::patch('update', [Key::class, 'update'])->name('update-key');
            Route::delete('delete', [Key::class, 'delete'])->name('delete-key');
            Route::get('list', [Key::class, 'list'])->name('key-list');
            Route::get('list-paginate', [Key::class, 'paginateList'])->name('key-list-paginate');
            Route::prefix('restrictions')->group(function () {
                Route::prefix('website')->group(function () {
                    Route::post('generate', [KeyWebsiteRestriction::class, 'store'])->name('generate-key-restrictions-website');
                    Route::patch('update', [KeyWebsiteRestriction::class, 'update'])->name('update-key-restrictions-website');
                    Route::delete('delete', [KeyWebsiteRestriction::class, 'delete'])->name('delete-key-restrictions-website');
                    Route::get('list', [KeyWebsiteRestriction::class, 'List'])->name('key-restrictions-website-list');
                    Route::get('list-paginate', [KeyWebsiteRestriction::class, 'paginateList'])->name('key-restrictions-website-list-paginate');
                });
                Route::prefix('ip-address')->group(function () {
                    Route::post('generate', [KeyIpAddressRestriction::class, 'store'])->name('generate-key-restrictions-ip-address');
                    Route::patch('update', [KeyIpAddressRestriction::class, 'update'])->name('update-key-restrictions-ip-address');
                    Route::delete('delete', [KeyIpAddressRestriction::class, 'delete'])->name('delete-key-restrictions-ip-address');
                    Route::get('list', [KeyIpAddressRestriction::class, 'list'])->name('key-restrictions-ip-address-list');
                    Route::get('list-paginate', [KeyIpAddressRestriction::class, 'paginateList'])->name('key-restrictions-ip-address-list-paginate');
                });
            });
        });
    });
});
