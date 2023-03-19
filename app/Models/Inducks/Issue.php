<?php

namespace App\Models\Inducks;

use App\Models\User;
use App\Models\UserList;
use App\Models\UserListItems\UserListIssue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inducks.issue';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'issuecode';

//    public function userLists(): HasMany
//    {
//        return $this->hasMany(UserListIssue::class, 'issue_code', 'issuecode');
//    }

    public function lists()
    {
        return $this->belongsToMany(UserList::class, 'user_list_issues');
    }
}
