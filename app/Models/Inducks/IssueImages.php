<?php

namespace App\Models\Inducks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueImages extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $table = 'inducks.issue_images';
    protected $primaryKey = 'issuecode';
    public $keyType = 'string';

}
