<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists;
use App\Models\ListItems as ListItem;

class ListItems extends Controller
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

        // Validate that a list id has been passed through the request
        $request->validate([
            'listId' => 'required',
        ]);

        // Handle unique session id and fetch user information
        $user = User::where('unique', $uniqueId)
                ->first();

        // Check for mismatch of user account
        if (empty($user)) {
            return response()->json([
                'status' => 2,
                'message' => 'User has not been found.'
            ]);
        }

        // Confirm that the user account is associated with the list 
        $list = Lists::where('user_id', $user->id)
                ->where('id', $request->listId)
                ->first();

        // Check for mismatch of user to list
        if (empty($list)) {
            return response()->json([
                'status' => 2,
                'message' => 'List has not been found.'
            ]);
        }

        // Create new list item in the database
        $listItem = new ListItem();
        $listItem->list_id = $list->id;
        $listItem->title = '';
        $listItem->content = '';
        $listItem->status = 1;
        $listItem->save();

        // Render the Blade component and return as a string
        $html = view('components.list-item', [
            'list_status' => 'open',
            'list_icon' => 'check_box_outline_blank',
            'list_content_header' => $listItem->title,
            'list_content_body' => $listItem->content,
            'list_content_date' => 'N/A',
            'list_id' => $list->id,
            'list_item_id' => $listItem->id
        ])->render();

        // Return successfully with the x compontent html
        return response()->json([
            'status' => 1,
            'message' => 'List item created. (' . $listItem->id . ')',
            'html' => $html
        ]);
    }

}


// 1155b966-a1a6-4094-8faa-58333bbe6a2a
