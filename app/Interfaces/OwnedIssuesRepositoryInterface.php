<?php

namespace App\Interfaces;

interface OwnedIssuesRepositoryInterface
{
    public function getOwnedIssues(int $userId, bool $compact, int $offset, int $limit);
    public function addOwnedIssue(int $userId, string $issueCode);
    public function removeOwnedIssues(int $userId, string $issueCode): bool;

}
