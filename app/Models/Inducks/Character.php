<?php

namespace App\Models\Inducks;

use App\Models\UserList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inducks.character';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'charactercode';

    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(UserList::class, 'user_list_characters');
    }
}
