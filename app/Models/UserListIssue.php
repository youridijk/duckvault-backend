<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserListIssue extends Model
{
    use HasFactory;

    public function userList(): HasOne
    {
        return $this->hasOne(UserList::class);
    }
}
