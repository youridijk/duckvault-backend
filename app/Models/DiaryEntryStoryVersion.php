<?php

namespace App\Models;

use App\Models\Diary\DiaryEntry;
use App\Models\Inducks\Issue;
use App\Models\Inducks\StoryVersion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DiaryEntryStoryVersion extends Model
{
    use HasFactory;

    protected $table = 'diary_entries_story_versions';

    public function diaryEntry()
    {
        return $this->belongsTo(DiaryEntry::class);
    }

    public function storyVersion(): HasOne
    {
        return $this->hasOne(StoryVersion::class, 'storyversioncode', 'story_version_code');
    }
}
