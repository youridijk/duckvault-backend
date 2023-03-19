<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Models\Inducks\Issue;
use App\Models\UserListItems\UserListIssue;

class UserListIssueController extends UserListItemController
{
    public function __construct()
    {
        parent::__construct(
            Issue::class,
            UserListIssue::class,
            'issue_code',
        );
    }
}
