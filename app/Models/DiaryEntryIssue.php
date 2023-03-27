<?php

namespace App\Models;

use App\Models\Diary\DiaryEntry;
use App\Models\Inducks\Issue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntryIssue extends Model
{
    use HasFactory;

    protected $table = 'diary_entries_issues';

    public function diaryEntry()
    {
        return $this->belongsTo(DiaryEntry::class);
    }

    public function issue()
    {
        return $this->hasOne(Issue::class, 'issuecode', 'issue_code');
    }
}
