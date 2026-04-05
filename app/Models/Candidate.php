<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'summary',
        'score',
        'raw_cv_path',
        'skills',
        'technical_skills',
        'soft_skills',
        'tools',
        'in_demand_skills',
        'job_matches',
        'recommendation',
        'cv_recommendation',
    ];

    protected $casts = [
        'skills' => 'array',
        'technical_skills' => 'array',
        'soft_skills' => 'array',
        'tools' => 'array',
        'in_demand_skills' => 'array',
        'job_matches' => 'array',
        'recommendation' => 'array',
        'cv_recommendation' => 'array',
    ];
}
