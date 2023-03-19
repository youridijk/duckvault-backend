<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Models\Inducks\Character;
use App\Models\UserListItems\UserListCharacter;

class UserListCharacterController extends UserListItemController
{
    public function __construct()
    {
        parent::__construct(
            Character::class,
            UserListCharacter::class,
            'character_code',
        );
    }
}
