<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Models\Inducks\Character;
use App\Models\Inducks\Story;
use App\Models\UserListItems\UserListCharacter;
use App\Models\UserListItems\UserListStory;

class UserListStoryController extends UserListItemController
{
    public function __construct()
    {
        parent::__construct(
            Story::class,
            UserListStory::class,
            'story_code',
        );
    }
}
