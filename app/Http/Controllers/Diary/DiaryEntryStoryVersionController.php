<?php

namespace App\Http\Controllers\Diary;

use App\Http\Requests\DiaryEntryRequest;
use App\Models\Inducks\Issue;
use App\Models\Inducks\StoryVersion;

class DiaryEntryStoryVersionController extends DiaryEntryController
{
    protected string $storeModel = StoryVersion::class;
    protected string $storeTable = 'diary_entries_story_versions';
    protected string $storeModelColumn = 'story_version_code';
    protected string $storeRelatedEntityType = 's';
}
