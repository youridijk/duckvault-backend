<?php

namespace App\Models;

use App\Models\Inducks\Issue;
use App\Models\UserListItems\UserListIssue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

//    public function issues(): HasMany
//    {
//        return $this->hasMany(UserListIssue::class);
//    }

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'user_list_issues', 'user_list_id','issue_code');
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

    protected $fillable = ['name', 'description', 'user_id'];
}
