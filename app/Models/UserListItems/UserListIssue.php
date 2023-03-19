<?php

namespace App\Models\UserListItems;

use App\Models\Inducks\Issue;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserListIssue extends UserListItem
{
    public function __construct(array $attributes = [])
    {
        parent::__construct('issue_code',$attributes);
    }

    public function issue(): HasOne
    {
        return $this->hasOne(Issue::class);
    }
}
