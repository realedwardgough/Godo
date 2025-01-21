<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lists as ListModel;
use App\Models\ListItems as ListItem;

class Lists extends Controller
{
    /**
     * Ensure the user exists and retrieve the authenticated user based on session.
     * 
     * @return \App\Models\User|\Illuminate\Http\JsonResponse
     */
    private function getAuthenticatedUser()
    {
        $uniqueId = session('unique_session_id');

        if (empty($uniqueId)) {
            return response()->json([
                'status' => 2,
                'message' => 'User session has not been found.',
            ]);
        }

        $user = User::where('unique', $uniqueId)->first();

        if (empty($user)) {
            return response()->json([
                'status' => 2,
                'message' => 'User has not been found.',
            ]);
        }

        return $user;
    }

    /**
     * Create a new list.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Create(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $list = new ListModel();
        $list->user_id = $user->id;
        $list->title = 'New List';
        $list->status = 1;
        $list->save();

        $html = view('components.list', [
            'id' => $list->id,
            'title' => $list->title,
        ])->render();

        return response()->json([
            'status' => 1,
            'message' => "List created. ({$list->id})",
            'reaction' => [
                [
                    'type' => 'insertAdjacentHTML',
                    'tag' => '.lists-wrapper',
                    'value' => $html,
                ],
                [
                    'type' => 'console',
                    'value' => "List created. ({$list->id})",
                ],
            ],
        ]);
    }

    /**
     * Delete a list.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $list = ListModel::where('id', $request->listId)
            ->where('user_id', $user->id)
            ->first();

        if (!$list) {
            return response()->json([
                'status' => 2,
                'message' => 'Access Denied',
                'reaction' => [
                    [
                        'type' => 'console',
                        'value' => 'Access Denied',
                    ],
                ],
            ]);
        }

        // Delete all list items.
        ListItem::where('list_id', $list->id)->delete();
        $list->delete();

        return response()->json([
            'status' => 1,
            'message' => "List item removed. ({$request->listId})",
            'reaction' => [
                [
                    'type' => 'remove',
                    'tag' => ".inner[data-list-id=\"{$request->listId}\"]",
                ],
                [
                    'type' => 'console',
                    'value' => "List item removed. ({$request->listId})",
                ],
            ],
        ]);
    }

    /**
     * Edit a list.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Edit(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }

        $list = ListModel::where('id', $request->listId)
            ->where('user_id', $user->id)
            ->first();

        if (!$list) {
            return response()->json([
                'status' => 2,
                'message' => 'Access Denied',
                'reaction' => [
                    [
                        'type' => 'console',
                        'value' => 'Access Denied',
                    ],
                ],
            ]);
        }

        $list->title = $request->title;
        $list->save();

        return response()->json([
            'status' => 1,
            'message' => 'List element updated.',
            'reaction' => [
                [
                    'type' => 'console',
                    'value' => 'List element updated.',
                ],
            ],
        ]);
    }

}
