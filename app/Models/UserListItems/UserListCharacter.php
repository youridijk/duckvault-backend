<?php

namespace App\Models\UserListItems;

use App\Models\Inducks\Character;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserListCharacter extends UserListItem
{
    public function __construct(array $attributes = [])
    {
        parent::__construct('character_code', $attributes);
    }

    public function character(): HasOne
    {
        return $this->hasOne(Character::class);
    }
}
