<?php

namespace App\Models\UserListItems;

use App\Models\UserList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserListItem extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function __construct(
        protected string $itemModelKey,
        array            $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = ['user_list_id', $this->itemModelKey];
        $this->primaryKey = ['user_list_id', $this->itemModelKey];
    }

    public function userList(): HasOne
    {
        return $this->hasOne(UserList::class);
    }
}
