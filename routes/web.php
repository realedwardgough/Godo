<?php

/**
 * Import necessary controllers and models for route definitions.
 */

use Illuminate\Support\Facades\Route;


/**
 * Web Routes for the Application
 */



 /**
 * Application Lists View
 * Middleware: None
 * Route name: 'lists'
 * Route URI: '/'
 * Description: This route renders the lists view of the application.
 */
Route::get('/', function () {
    return view('lists');
})->name('lists');
