<?php

namespace App\Http\Controllers\UserListItems;

use App\Models\Inducks\Issue;

class UserListIssueController extends UserListItemController
{
    protected string $shortClassName = 'issue';

    protected string $itemModel = Issue::class;

    protected string $relationKey = 'issues';

    protected string $itemModelKey = 'issue_code';
}
