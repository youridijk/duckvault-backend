<?php

namespace App\Repositories;

use App\Interfaces\OwnedIssuesRepositoryInterface;
use App\Models\OwnedIssue;

class OwnedIssuesRepository implements OwnedIssuesRepositoryInterface
{
    public function getOwnedIssues(int $userId, bool $compact, int $offset, int $limit)
    {
        if ($compact) {
            return OwnedIssue::where('user_id', '=', $userId)
                ->select(['issue_code', 'created_at'])
                ->offset($offset)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            return OwnedIssue::with([
                'issue:issuecode,publicationcode,title,issuenumber,oldestdate,filledoldestdate',
                'issue.publication:publicationcode,title',
                'issue.images',
            ])
                ->where('user_id', '=', $userId)
                ->offset($offset)
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }


    public function addOwnedIssue(int $userId, string $issueCode)
    {
        return OwnedIssue::create([
            'issue_code' => $issueCode,
            'user_id' => $userId,
        ]);
    }

    public function removeOwnedIssues(int $userId, string $issueCode): bool
    {
        return OwnedIssue::where('issue_code', '=', $issueCode)
            ->where('user_id', '=', $userId)
            ->delete();
    }
}
