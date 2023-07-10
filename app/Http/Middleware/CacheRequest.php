<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $urlRequestUri = $request->getRequestUri();
        $routeName = $request->route()->getName();
        $requestUserId = $request->get('user_id');
        $cacheTags = [$routeName, $requestUserId ?? Auth::id()];

        $request->attributes->add(['cache_tags' => $cacheTags]);

        if ($cachedResponse = Cache::tags($cacheTags)->get($urlRequestUri)) {
            error_log('from cache ' . $urlRequestUri);
            $request->attributes->add(['cache' => true]);
            return response($cachedResponse, 200)
                ->header('Content-Type', 'application/json');
        }

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if ($request->get('cache')) {
            return;
        }

        $cacheTags = $request->attributes->get('cache_tags');

        $urlRequestUri = $request->getRequestUri();
        error_log('caching ' . $urlRequestUri);

        if ($response->isSuccessful()) {
            Cache::tags($cacheTags)->put($urlRequestUri, $response->getContent());
        }
    }

}
