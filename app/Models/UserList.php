<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserList extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_lists';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected string $name;

    protected string $description;

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(UserListIssue::class);
    }

//    public function publications()
//    {
//        return $this->hasMany(UserListPublication::class);
//    }

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
//    protected $visible = ['quote', 'context', 'creator_id', 'sayer_id'];

    protected $fillable = ['name', 'description', 'user_id'];
}
