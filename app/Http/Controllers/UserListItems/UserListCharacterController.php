<?php

namespace App\Http\Controllers\UserListItems;

use App\Models\Inducks\Character;

class UserListCharacterController extends UserListItemController
{
    protected string $shortClassName = 'character';

    protected string $itemModel = Character::class;

    protected string $relationKey = 'characters';

    protected string $itemModelKey = 'character_code';
}
