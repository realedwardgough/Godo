<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists as ListModel;

class Lists extends Controller
{
    
    /**
     * Creates new list and generates the html
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

    /**
     * Removes list and generates the html
     * via the x component which is also used on the route view
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     * 
     */
    public function Delete(Request $request) {
        
        
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

        // Search for the list item which is to be deleted and confirm user has access to this
        $list = ListModel::where('id', $request->listId)
                ->where('user_id', $user->id)
                ->first();

        /**
         * 
         * This will need to find all list items within the 
         * current list and remove after the list has been deleted.
         * 
         */

        // Access missing and must throw error and show console message
        if (!$list) {
            return response()->json([
                'status' => 2,
                'message' => 'Access Denied',
                'reaction' => [
                    0 => [
                        'type' => 'console',
                        'value' => 'Access Denied'
                    ]
                ]
            ]);
        }

        // Found and not returned early, list is applicable for deletion
        $list->delete();

        // Return successfully with the x compontent removed from dom
        return response()->json([
            'status' => 1,
            'message' => 'List item removed. (' . $request->listId . ')',
            'reaction' => [
                0 => [
                    'type' => 'remove',
                    'tag' => '.inner[data-list-id="'.$request->listId.'"]'
                ],
                1 => [
                    'type' => 'console',
                    'value' => 'List item removed. (' . $request->listId . ')'
                ]
            ]
        ]);
    }

    /**
     * Edit list and generates the html
     * via the x component which is also used on the route view
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     * 
     */
    public function Edit(Request $request) {
        
        
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

        // Search for the list item which is to be deleted and confirm user has access to this
        $list = ListModel::where('id', $request->listId)
                ->where('user_id', $user->id)
                ->first();


        // Access missing and must throw error and show console message
        if (!$list) {
            return response()->json([
                'status' => 2,
                'message' => 'Access Denied',
                'reaction' => [
                    0 => [
                        'type' => 'console',
                        'value' => 'Access Denied'
                    ]
                ]
            ]);
        }

        // Found and not returned early, list is applicable for deletion
        $list->title = $request->title;
        $list->save();

        // Return successfully with the x compontent removed from dom
        return response()->json([
            'status' => 1,
            'message' => 'List element updated.',
            'reaction' => [
                0  => [
                    'type' => 'console',
                    'value' => 'List element updated.'
                ]
            ]
        ]);
    }

}
