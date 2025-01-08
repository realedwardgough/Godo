<?php

/**
 * Import necessary controllers and models for route definitions.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UniqueSession;
use App\Models\User;

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
        
        // Store localised unique session id
        $uniqueId = session('unique_session_id');
        
        // Check if unique session id hasn't been set
        if (empty($uniqueId)) {
            $user = [];
        }

        // Handle unique session id and fetch user information
        else {
            $user = User::where('unique', $uniqueId)
                ->first();
        }
        
        // Return route view lists with user information
        return view('lists', ['user' => $user]);
    })->name('lists');

});