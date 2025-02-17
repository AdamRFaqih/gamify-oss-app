<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'issue_id',
        'number',
        'title',
        'url',
        'state',
    ];
}
