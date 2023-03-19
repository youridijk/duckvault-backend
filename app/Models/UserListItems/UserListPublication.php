<?php

namespace App\Models\UserListItems;

use App\Models\Inducks\Character;
use App\Models\Inducks\Publication;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserListPublication extends UserListItem
{
    public function __construct(array $attributes = [])
    {
        parent::__construct('publication_code', $attributes);
    }

    public function character(): HasOne
    {
        return $this->hasOne(Publication::class);
    }
}
