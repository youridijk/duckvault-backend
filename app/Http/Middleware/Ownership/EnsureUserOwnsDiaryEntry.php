<?php

namespace App\Http\Middleware\Ownership;

class EnsureUserOwnsDiaryEntry extends EnsureUserOwnsEntity
{
    protected string $routeParameter = 'diary_entry';

    protected string $userRelation = 'diaryEntries';

    protected string $entityName = 'Diary entry';
}
