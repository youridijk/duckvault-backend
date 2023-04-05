<?php

namespace App\Http\Controllers\Diary;

use App\Http\Requests\DiaryEntryRequest;
use App\Models\Inducks\Issue;

class DiaryEntryIssueController extends DiaryEntryController
{
    protected string $storeModel = Issue::class;
    protected string $storeTable = 'diary_entries_issues';
    protected string $storeModelColumn = 'issue_code';
    protected string $storeRelatedEntityType = 'i';
}
