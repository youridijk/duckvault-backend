<?php

namespace App\Models;

use App\Models\Inducks\Issue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OwnedIssue extends Model
{
    use HasFactory;

    protected $table = 'owned_issues';

    protected $fillable = ['issue_code', 'user_id'];

    protected $primaryKey = null;
    public $incrementing = false;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function issue(): HasOne
    {
        return $this->hasOne(Issue::class, 'issuecode', 'issue_code');
    }

    public static function find(string $issueCode, int $userId) {

        return OwnedIssue::where('issue_code', '=', $issueCode)
            ->where('user_id', '=', $userId)
            ->first();
    }
}
