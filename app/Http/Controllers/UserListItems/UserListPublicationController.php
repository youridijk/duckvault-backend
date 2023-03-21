<?php

namespace App\Http\Controllers\UserListItems;

use App\Models\Inducks\Publication;

class UserListPublicationController extends UserListItemController
{
    protected string $shortClassName = 'publication';

    protected string $itemModel = Publication::class;

    protected string $relationKey = 'publications';

    protected string $itemModelKey = 'publication_code';
}
