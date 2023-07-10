<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class FlushCachedRequest
{
    public function handle(Request $request, Closure $next, ...$routeNames): Response
    {
        error_log(json_encode($routeNames));

//        $cacheTagsArray = [$routeNames, $requestUserId ?? Auth::id()];
        $requestUserId = $request->get('user_id');
        $cacheTagsArray = array_map(function ($routeName) use ($requestUserId) {
            return [$routeName, $requestUserId ?? Auth::id()];
        }, $routeNames);

        $request->attributes->add(['cache_tags_array' => $cacheTagsArray]);
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (!$response->isSuccessful()) {
            return;
        }

        $cacheTagsArray = $request->attributes->get('cache_tags_array');

        foreach ($cacheTagsArray as $cacheTags) {
            error_log('flushed '   .  json_encode($cacheTags));
            Cache::tags($cacheTags)->flush();
        }
    }
}
