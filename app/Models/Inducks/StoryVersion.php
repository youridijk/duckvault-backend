<?php

namespace App\Models\Inducks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryVersion extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inducks.storyversion';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'storyversioncode';

    public function story()
    {
        return $this->hasOne(Story::class, 'storycode', 'storycode');
    }
}
