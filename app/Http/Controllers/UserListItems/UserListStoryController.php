<?php

namespace App\Http\Controllers\UserListItems;

use App\Models\Inducks\Story;

class UserListStoryController extends UserListItemController
{
    protected string $shortClassName = 'story';

    protected string $itemModel = Story::class;

    protected string $relationKey = 'stories';

    protected string $itemModelKey = 'story_code';
}
