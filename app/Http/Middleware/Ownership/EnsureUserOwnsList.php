<?php

namespace App\Http\Middleware\Ownership;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsList extends EnsureUserOwnsEntity
{
    protected string $routeParameter = 'list';

    protected string $userRelation = 'lists';

    protected string $entityName = 'List';
}
