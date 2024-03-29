<?php

namespace App\Models;

use App\Models\Inducks\Character;
use App\Models\Inducks\Issue;
use App\Models\Inducks\Publication;
use App\Models\Inducks\Story;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(
            Issue::class,
            'user_list_issues',
            'user_list_id',
            'issue_code'
        )->withTimestamps();
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(
            Publication::class,
            'user_list_publications',
            'user_list_id',
            'publication_code'
        )->withTimestamps();
    }

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(
            Story::class,
            'user_list_stories',
            'user_list_id',
            'story_code'
        )->withTimestamps();
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(
            Character::class,
            'user_list_characters',
            'user_list_id',
            'character_code'
        )->withTimestamps();
    }

    protected $fillable = ['name', 'description', 'user_id'];
}
