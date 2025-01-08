<?php

/**
 * Import necessary controllers and models for route definitions.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UniqueSession;


/**
 * Web Routes for the Application
 */
Route::middleware( UniqueSession::class )->group(function () {

    /**
     * Application Lists View
     * Middleware: UniqueSession
     * Route name: 'lists'
     * Route URI: '/'
     * Description: This route renders the lists view of the application.
     */
    Route::get('/', function () {
        return view('lists');
    })->name('lists');

});