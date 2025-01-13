<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists as ListModel;

class Lists extends Controller
{
    
    /**
     * Creates new list item and generates the html
     * via the x component which is also used on the route view
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     * 
     */
    public function Create(Request $request) {
        
        
        // Store localised unique session id
        $uniqueId = session('unique_session_id');
        
        // Check if unique session id hasn't been set
        if (empty($uniqueId)) {
            return response()->json([
                'status' => 2,
                'message' => 'User session has not been found.'
            ]);
        }

        // Handle unique session id and fetch user information
        $user = User::where('unique', $uniqueId)
                ->first();

        // User has not been found from the unique session id
        if (empty($user)) {
            return response()->json([
                'status' => 2,
                'message' => 'User has not been found.'
            ]);
        }

        // Create new list item in the database
        $list = new ListModel();
        $list->user_id = $user->id;
        $list->title = 'New List';
        $list->status = 1;
        $list->save();

        // Render the Blade component and return as a string
        $html = view('components.list', [
            'id' => $list->id,
            'title' => $list->title
        ])->render();

        // Return successfully with the x compontent html
        return response()->json([
            'status' => 1,
            'message' => 'List created. (' . $list->id . ')',
            'reaction' => [
                0 => [
                    'type' => 'insertAdjacentHTML',
                    'tag' => '.lists-wrapper',
                    'value' => $html
                ],
                1 => [
                    'type' => 'console',
                    'value' => 'List created. (' . $list->id . ')'
                ]
            ]
        ]);
    }

}
