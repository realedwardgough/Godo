<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Http\Controllers\Users;
use App\Models\User;

class UniqueSession
{
    /**
     * Summary of handle
     * 
     * @param mixed $request
     * @param \Closure $next
     * @return mixed
     * 
     */
    public function handle($request, Closure $next): mixed {
        
        // Check for missing unique session id 
        if (!session()->has('unique_session_id')) {
            
            // Create unique session id
            session(['unique_session_id' => Str::uuid()]);

            // Create new user account with unique session id
            $users = new Users();
            $users -> Create();
        }

        // 
        else {

            /**
             * Store localised unique session id,
             * and check database for matching id
             */
            $unique_id = session('unique_session_id');
            $userFound = User::where('unique', $unique_id)->first();

            // Create new user account with unique session id
            if (empty($userFound)) {
                
                $users = new Users();
                $users -> Create();
            }
        }

        // 
        return $next($request);
    }
}
