<?php

namespace App\Http\Middleware\Ownership;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnsureUserOwnsEntity
{
    protected string $routeParameter;

    protected string $userRelation;

    protected string $entityName;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route($this->routeParameter);
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'int']
        ]);

        $relationEntities = call_user_func(array(Auth::user(), $this->userRelation));
        $relationEntity = $relationEntities->find($id);

        if (!$relationEntity) {
            throw new NotFoundHttpException($this->entityName . ' with id ' . $id . ' not found');
        }

        $request[$this->routeParameter] = $relationEntity;

        return $next($request);
    }
}
