<?php

namespace App\Http\Middleware;

use App\Models\UserList;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnsureUserOwnsList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('list');
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'int']
        ]);

        try {
            $userList = UserList::findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new NotFoundHttpException('List with id ' . $id . ' not found');
        }

        if ($userList->user_id !== Auth::id()) {
            throw new AuthenticationException( 'You don\'t own with list');
        }

        $request['user_list'] = $userList;

        return $next($request);
    }
}
