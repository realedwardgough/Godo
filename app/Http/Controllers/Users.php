<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class Users extends Controller
{
    
    /**
     * Summary of Create
     * @return string
     */
    public function Create() {

        // Store localised unique session id
        $unique_id = session('unique_session_id');

        /**
         * Check unique session id has already been created
         * before adding user
         */
        if (empty($unique_id)) {
            dd('missing unique_id');
            return redirect()
                ->route('lists')
                ->with(
                'error', "--- Missing Unique ID ---"
            );
        }

        /**
         * Create user record in database
         */
        $user = new User();
        $user->unique = $unique_id;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user-> save();

        // 
        return '--- User Account Created ---';

    }


}
