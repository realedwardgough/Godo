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
        
        
        //
        $userAccess = $this->CheckUserHasAccessToList($request);

        //
        if ($userAccess['status'] != 1) {
            return response()->json([
                'status' => $userAccess['status'],
                'message' => $userAccess['message'],
                'reaction' => [
                    0 => [
                        'type' => 'console',
                        'value' => $userAccess['message']
                    ]
                ]
            ]);
        }

        //
        $list = $userAccess['list'];

        // Create new list item in the database
        $listItem = new ListItem();
        $listItem->list_id = $list->id;
        $listItem->title = 'New List Item';
        $listItem->content = 'What do you need complete?';
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
            'reaction' => [
                0 => [
                    'type' => 'insertAdjacentHTML',
                    'tag' => '.list-container[data-listid="'.$list->id.'"]',
                    'value' => $html
                ],
                1 => [
                    'type' => 'console',
                    'value' => 'List item created. (' . $listItem->id . ')'
                ]
            ]
        ]);
    }


    /**
     * Removes list item and the html for it
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     * 
     */
    public function Delete(Request $request) {

        // Check users access rights for the list and list item
        $userAccess = $this->CheckUserHasAccessToList($request);

        // Failed access rights, return error and console
        if ($userAccess['status'] != 1) {
            return response()->json([
                'status' => $userAccess['status'],
                'message' => $userAccess['message'],
                'reaction' => [
                    0 => [
                        'type' => 'console',
                        'value' => $userAccess['message']
                    ]
                ]
            ]);
        }

        // Validate that a list id has been passed through the request
        $list = $userAccess['list'];
        $request->validate([
            'listItemId' => 'required|integer|exists:list_item,id',
        ]);

        // Search for the list item which is to be deleted and confirm user has access to this
        $listItem = ListItem::where('id', $request->listItemId)
                ->where('list_id', $list->id)
                ->first();

        // Access missing and must throw error and show console message
        if (!$listItem) {
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
        $listItem->delete();

        // Return successfully with the x compontent removed from dom
        return response()->json([
            'status' => 1,
            'message' => 'List item removed. (' . $request->listItemId . ')',
            'reaction' => [
                0 => [
                    'type' => 'remove',
                    'tag' => '[data-list-item-id="'.$request->listItemId.'"]'
                ],
                1 => [
                    'type' => 'console',
                    'value' => 'List item removed. (' . $request->listItemId . ')'
                ]
            ]
        ]);

    }

    /**
     * Edits list item and the html for it
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     * 
     */
    public function Edit(Request $request) {

        // Check users access rights for the list and list item
        $userAccess = $this->CheckUserHasAccessToList($request);

        // Failed access rights, return error and console
        if ($userAccess['status'] != 1) {
            return response()->json([
                'status' => $userAccess['status'],
                'message' => $userAccess['message'],
                'reaction' => [
                    0 => [
                        'type' => 'console',
                        'value' => $userAccess['message']
                    ]
                ]
            ]);
        }

        // Validate that a list id has been passed through the request
        $list = $userAccess['list'];
        $request->validate([
            'listItemId' => 'required|integer|exists:list_item,id',
        ]);

        // Search for the list item which is to be edited and confirm user has access to this
        $listItem = ListItem::where('id', $request->listItemId)
                ->where('list_id', $list->id)
                ->first();

        // Access missing and must throw error and show console message
        if (!$listItem) {
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

        // Found and not returned early, list is applicable for edit
        $listItem->title = $request->title;
        $listItem->content = $request->content; 
        $listItem->save(); 

        // Return successfully with the x compontent removed from dom
        return response()->json([
            'status' => 1,
            'message' => 'List item removed. (' . $request->listItemId . ')',
            'reaction' => [
                0 => [
                    'type' => 'console',
                    'value' => 'List item updated. (' . $request->listItemId . ')'
                ]
            ]
        ]);

    }


    /**
     * Confirms that the user has access to the list item or list
     * which has been selected for actionable request
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     * 
     */
    private function CheckUserHasAccessToList(Request $request) {
        
        // Store localised unique session id
        $uniqueId = session('unique_session_id');
        
        // Check if unique session id hasn't been set
        if (empty($uniqueId)) {
            return [
                'status' => 2,
                'message' => 'User session has not been found.'
            ];
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
            return [
                'status' => 2,
                'message' => 'User has not been found.'
            ];
        }

        // Confirm that the user account is associated with the list 
        $list = Lists::where('user_id', $user->id)
                ->where('id', $request->listId)
                ->first();

        // Check for mismatch of user to list
        if (empty($list)) {
            return [
                'status' => 2,
                'message' => 'List has not been found.'
            ];
        }

        // 
        return [
            'status' => 1,
            'message' => 'User has access to selected list.',
            'list' => $list
        ];

    }



}


// 1155b966-a1a6-4094-8faa-58333bbe6a2a
