<?php

namespace App\Models\UserListItems;

use App\Models\Inducks\Character;
use App\Models\Inducks\Story;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserListStory extends UserListItem
{
    public function __construct(array $attributes = [])
    {
        parent::__construct('story_code', $attributes);
    }

    public function character(): HasOne
    {
        return $this->hasOne(Story::class);
    }
}
