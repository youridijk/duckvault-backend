<?php

namespace App\Models\Inducks;

use App\Models\UserList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publication extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inducks.publication';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'publicationcode';

    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(
            UserList::class,
            'user_list_publications',
            'publication_code',
            'user_list_id'
        )->withTimestamps();
    }
}
