<?php

namespace App\Providers;

use App\Interfaces\OwnedIssuesRepositoryInterface;
use App\Repositories\OwnedIssuesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OwnedIssuesRepositoryInterface::class, OwnedIssuesRepository::class);
    }
}
