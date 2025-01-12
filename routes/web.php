<?php

/**
 * Import necessary controllers and models for route definitions.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UniqueSession;
use App\Models\User;
use App\Http\Controllers\ListItems;

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


    /**
     * Application Lists Retrieve
     * Middleware: UniqueSession
     * Route name: 'retrieve'
     * Route URI: '/retrieve/{uniqueId}'
     * Description: This route renders passed unique session id
     * to enabled updated session to view previous to-do list items.
     */
    Route::get('/retrieve/{uniqueId}', function ($uniqueId) {
        
        // Handle unique session id and update unique session id
        if (!empty($uniqueId)) {
            session(['unique_session_id' => $uniqueId]);
        }
        
        // Return route view lists with user information
        return redirect()->route('lists');
    })->name('retrieve');


    /**
     * Application Lists Retrieve
     * Middleware: UniqueSession
     * Route name: 'create.list-item'
     * Route URI: '/create/list-item'
     * Description: This route renders passed unique session id
     * to enabled updated session to view previous to-do list items.
     */
    Route::post('/create/list-item', [ListItems::class, 'Create'])->name('create.list-item');

    /**
     * Application Lists Retrieve
     * Middleware: UniqueSession
     * Route name: 'delete.list-item'
     * Route URI: '/delete/list-item'
     * Description: This route renders passed unique session id
     * to enabled updated session to view previous to-do list items.
     */
    Route::post('/delete/list-item', [ListItems::class, 'Delete'])->name('delete.list-item');

    /**
     * Application Lists Retrieve
     * Middleware: UniqueSession
     * Route name: 'edit.list-item'
     * Route URI: '/edit/list-item'
     * Description: This route renders passed unique session id
     * to enabled updated session to view previous to-do list items.
     */
    Route::post('/edit/list-item', [ListItems::class, 'Edit'])->name('edit.list-item');


});