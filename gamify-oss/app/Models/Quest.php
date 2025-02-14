<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = [
        'issue_id',
        'title',
        'description',
        'role_dev',
        'difficulty',
        'required_level',
        'proficiency_reward',
        'experience_reward',
        'status',
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
