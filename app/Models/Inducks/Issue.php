<?php

namespace App\Models\Inducks;

use App\Models\UserList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    public $incrementing = false;

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

    public function lists()
    {
        return $this->belongsToMany(
            UserList::class,
            'user_list_issues',
            'issue_code',
            'user_list_id'
        )->withTimestamps();
    }
}
