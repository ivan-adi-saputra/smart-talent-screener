<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'candidate_id',
        'message',
        'response',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
