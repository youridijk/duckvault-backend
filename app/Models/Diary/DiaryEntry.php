<?php

namespace App\Models\Diary;

use App\Models\DiaryEntryIssue;
use App\Models\DiaryEntryStoryVersion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DiaryEntry extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function diaryEntryIssue()
    {
        return $this->hasOne(DiaryEntryIssue::class, 'diary_entry_id', 'id');
    }

    public function diaryEntryStoryVersion()
    {
        return $this->hasOne(DiaryEntryStoryVersion::class, 'diary_entry_id', 'id');
    }


    protected $fillable = [
        'user_id',
//        'review_id',
        'reread',
        'spoilers',
        'liked',
        'read_on',
        'related_entity_type',
    ];
}
