<?php

namespace App\Http\Controllers\UserListItems;

use App\Http\Controllers\Controller;
use App\Models\Inducks\Character;
use App\Models\Inducks\Publication;
use App\Models\UserListItems\UserListCharacter;
use App\Models\UserListItems\UserListPublication;

class UserListPublicationController extends UserListItemController
{
    public function __construct()
    {
        parent::__construct(
            Publication::class,
            UserListPublication::class,
            'publication_code',
        );
    }
}
